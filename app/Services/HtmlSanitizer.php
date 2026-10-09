<?php

namespace App\Services;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;

class HtmlSanitizer
{
    /**
     * Whitelist of permitted HTML tags.
     */
    protected static array $allowedTags = [
        'p', 'h2', 'h3', 'h4', 'h5', 'h6',
        'ul', 'ol', 'li',
        'strong', 'b', 'em', 'i', 'u', 's', 'small',
        'blockquote', 'pre', 'code',
        'a', 'img', 'figure', 'figcaption',
        'br', 'hr',
        'div', 'span',
    ];

    /**
     * Whitelist of permitted attributes per tag.
     */
    protected static array $allowedAttributes = [
        'a' => ['href', 'title', 'target', 'rel'],
        'img' => ['src', 'alt', 'title', 'width', 'height', 'loading'],
        'figure' => ['class'],
        'figcaption' => ['class'],
        'p' => ['class'],
        'blockquote' => ['class'],
        'pre' => ['class'],
        'code' => ['class'],
        'h2' => ['class', 'id'],
        'h3' => ['class', 'id'],
        'h4' => ['class', 'id'],
        'div' => ['class'],
        'span' => ['class'],
    ];

    /**
     * Whitelist of allowed URL schemes for href and src.
     */
    protected static array $allowedSchemes = ['http', 'https', 'mailto', 'tel'];

    /**
     * Clean and sanitize input HTML.
     */
    public static function clean(?string $html): string
    {
        if (empty($html)) {
            return '';
        }

        // Quick defense against script/iframe tags
        $html = preg_replace('/<\s*(script|style|iframe|object|embed|applet|form|svg|canvas)[^>]*>.*?<\s*\/\s*\1\s*>/is', '', $html);
        $html = preg_replace('/<\s*(script|style|iframe|object|embed|applet|form|svg|canvas)[^>]*>/is', '', $html);

        $libxmlState = libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        // Wrap with UTF-8 meta to preserve accents and Indonesian characters
        $wrappedHtml = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>' . $html . '</body></html>';
        
        $dom->loadHTML($wrappedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($libxmlState);

        $body = $dom->getElementsByTagName('body')->item(0);
        if (!$body) {
            return '';
        }

        static::sanitizeNode($body);

        // Extract inner HTML of body
        $cleanHtml = '';
        foreach ($body->childNodes as $child) {
            $cleanHtml .= $dom->saveHTML($child);
        }

        return trim($cleanHtml);
    }

    /**
     * Recursively sanitize DOM nodes.
     */
    protected static function sanitizeNode(DOMNode $node): void
    {
        $children = [];
        foreach ($node->childNodes as $child) {
            $children[] = $child;
        }

        foreach ($children as $child) {
            if ($child->nodeType === XML_ELEMENT_NODE) {
                /** @var DOMElement $child */
                $tagName = strtolower($child->nodeName);

                if (!in_array($tagName, static::$allowedTags, true)) {
                    // Tag is not allowed. Move its children up, then remove node
                    while ($child->firstChild) {
                        $child->parentNode->insertBefore($child->firstChild, $child);
                    }
                    $child->parentNode->removeChild($child);
                    continue;
                }

                // Sanitize attributes
                $allowedAttrs = static::$allowedAttributes[$tagName] ?? [];
                $attributesToRemove = [];

                if ($child->hasAttributes()) {
                    foreach ($child->attributes as $attr) {
                        $attrName = strtolower($attr->nodeName);

                        // Strip any event handler attribute (e.g. onclick, onerror)
                        if (str_starts_with($attrName, 'on')) {
                            $attributesToRemove[] = $attrName;
                            continue;
                        }

                        if (!in_array($attrName, $allowedAttrs, true)) {
                            $attributesToRemove[] = $attrName;
                            continue;
                        }

                        // Validate URL attributes
                        if (in_array($attrName, ['href', 'src'], true)) {
                            $value = trim($attr->nodeValue);
                            if (!static::isSafeUrl($value)) {
                                $attributesToRemove[] = $attrName;
                                continue;
                            }

                            // If link has target="_blank", ensure rel="noopener noreferrer"
                            if ($tagName === 'a' && $child->getAttribute('target') === '_blank') {
                                $child->setAttribute('rel', 'noopener noreferrer');
                            }
                        }
                    }

                    foreach ($attributesToRemove as $attrName) {
                        $child->removeAttribute($attrName);
                    }
                }

                // Recursively clean children
                static::sanitizeNode($child);
            } elseif ($child->nodeType === XML_COMMENT_NODE) {
                // Strip HTML comments
                $child->parentNode->removeChild($child);
            }
        }
    }

    /**
     * Validate whether a URL is safe.
     */
    protected static function isSafeUrl(string $url): bool
    {
        if (empty($url)) {
            return false;
        }

        // Relative URLs are safe
        if (str_starts_with($url, '/') || str_starts_with($url, './') || str_starts_with($url, '../') || str_starts_with($url, '#')) {
            return true;
        }

        $parsed = parse_url($url);
        if (!$parsed || !isset($parsed['scheme'])) {
            // Could be relative path like "images/photo.jpg"
            return !str_contains($url, ':');
        }

        $scheme = strtolower($parsed['scheme']);
        return in_array($scheme, static::$allowedSchemes, true);
    }
}
