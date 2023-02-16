<?php

namespace LivewireKit\Support;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\View\Factory;
use Illuminate\View\Component;

final class Blade
{
    /**
     * Check to see if component class uses a certain component trait
     *
     * @return bool
     */
    public static function componentHasTrait(string|Component $component, string $trait, ?bool $throw = false)
    {
        if (! trait_exists($trait)) {

            if (! $throw) return false;

            throw new Exception(
                "\"{$trait}\" component trait does not exists"
            );
        }

        if (is_string($component) && ! is_subclass_of($component, Component::class)) {

            if (! $throw) return false;

            throw new Exception(
                "\"{$component}\" is not a subclass of \"".Component::class."\""
            );
        }

        return in_array(
            $trait,
            class_uses($component)
        );
    }

    /**
     * Check if component has certain property defined
     *
     * @var Component
     * @var string|array
     * @return void
     */
    public static function hasProperty(Component $component, string $property): bool
    {
        return in_array($property, array_keys(get_object_vars($component)));
    }

    public static function from(string $string): \Illuminate\View\View
    {
        $class = new class extends Component {

            public static function fromString(string $content, Factory $viewFactory): string
            {
                return (new static)->createBladeViewFromString(
                    $viewFactory,
                    $content
                );
            }

            public function render() {}
        };

        $component = $class::fromString($string, app('view'));

        return View::make($component);
    }

    public static function lookup(string $component): string|null
    {
        $componentClass = (
            (new Collection(explode('.', $component)))
                ->map(fn ($ns) => Str::ucfirst(Str::camel($ns)))
                ->join('\\')
        );

        $classNamespaces = [
            "\\App\\View\\Components",
            "\\LivewireKit\\View\\Components",
        ];

        $viewNamespaces = [
            'components',
            'livewirekit::components'
        ];

        $class = (
            (new Collection($classNamespaces))
                ->map(fn ($namespace): string|null => (
                    class_exists($className = "{$namespace}\\{$componentClass}")
                        ? $className
                        : null
                ))
                ->whereNotNull()
                ->first()
        );

        if ($class) {
            return $class;
        }

        $view = (
            (new Collection($viewNamespaces))
                ->map(fn ($namespace): string|null => (
                    View::exists($viewName = "{$namespace}.{$component}")
                        ? $viewName
                        : null
                ))
                ->whereNotNull()
                ->first()
        );

        if ($view) {
            return $view;
        }

        return null;
    }

    public static function isHtml5Tag(string $tag): bool
    {
        return in_array($tag, static::html5Tags());
    }

    public static function isHtml5SelfClosingTag(string $tag): bool
    {
        return in_array($tag, [
            'area',
            'base',
            'br',
            'col',
            'embed',
            'hr',
            'img',
            'input',
            'link',
            'meta',
            'param',
            'source',
            'track',
            'wbr',
        ]);
    }

    /**
     * @return string[]
     */
    public static function html5Tags(): array
    {
        return [
            "a",
            "abbr",
            "address",
            "area",
            "article",
            "aside",
            "audio",
            "b",
            "base",
            "bdi",
            "bdo",
            "blockquote",
            "body",
            "br",
            "button",
            "canvas",
            "caption",
            "cite",
            "code",
            "col",
            "colgroup",
            "data",
            "datalist",
            "dd",
            "del",
            "details",
            "dfn",
            "dialog",
            "div",
            "dl",
            "dt",
            "em",
            "embed",
            "fieldset",
            "figcaption",
            "figure",
            "footer",
            "form",
            "head",
            "header",
            "hgroup",
            "h1 to h6",
            "hr",
            "html",
            "i",
            "iframe",
            "img",
            "input",
            "ins",
            "kbd",
            "keygen",
            "label",
            "legend",
            "li",
            "link",
            "main",
            "map",
            "mark",
            "menu",
            "menuitem",
            "meta",
            "meter",
            "nav",
            "noscript",
            "object",
            "ol",
            "optgroup",
            "option",
            "output",
            "p",
            "param",
            "picture",
            "pre",
            "progress",
            "q",
            "rp",
            "rt",
            "ruby",
            "s",
            "samp",
            "script",
            "section",
            "select",
            "small",
            "source",
            "span",
            "strong",
            "style",
            "sub",
            "summary",
            "sup",
            "svg",
            "table",
            "tbody",
            "td",
            "template",
            "textarea",
            "tfoot",
            "th",
            "thead",
            "time",
            "title",
            "tr",
            "track",
            "u",
            "ul",
            "var",
            "video",
            "wbr",
        ];
    }
}