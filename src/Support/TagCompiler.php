<?php

namespace Ja\Livewire\Support;

use Illuminate\Support\Str;
use Illuminate\View\Compilers\ComponentTagCompiler;
use InvalidArgumentException;

class TagCompiler extends ComponentTagCompiler
{
    public function compile(string $value)
    {
        $value = $this->compileSelfClosingTags($value);
        $value = $this->compileOpeningTags($value);
        $value = $this->compileClosingTags($value);

        return $value;
    }

    protected function compileOpeningTags(string $value)
    {
        $pattern = "/
      <
        \s*
        blade[-\:]([\w\-\:\.]*)
        (?<attributes>
          (?:
            \s+
            (?:
              (?:
                \{\{\s*\\\$attributes(?:[^}]+?)?\s*\}\}
              )
              |
              (?:
                [\w\-:.@]+
                (
                  =
                  (?:
                    \\\"[^\\\"]*\\\"
                    |
                    \'[^\']*\'
                    |
                    [^\'\\\"=<>]+
                  )
                )?
              )
            )
          )*
          \s*
        )
        (?<![\/=\-])
      >
    /x";

        return preg_replace_callback($pattern, function (array $matches) {
            $this->boundAttributes = [];

            $attributes = $this->getAttributesFromAttributeString($matches['attributes']);

            return $this->componentString($matches[1], $attributes);
        }, $value);
    }

    /**
     * Compile the self-closing tags within the given string.
     *
     * @param  string  $value
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function compileSelfClosingTags(string $value)
    {
        $pattern = "/
      <
        \s*
        blade[-\:]([\w\-\:\.]*)
        \s*
        (?<attributes>
          (?:
            \s+
            (?:
              (?:
                \{\{\s*\\\$attributes(?:[^}]+?)?\s*\}\}
              )
              |
              (?:
                [\w\-:.@]+
                (
                  =
                  (?:
                    \\\"[^\\\"]*\\\"
                    |
                    \'[^\']*\'
                    |
                    [^\'\\\"=<>]+
                  )
                )?
              )
            )
          )*
          \s*
        )
      \/>
    /x";

        return preg_replace_callback($pattern, function (array $matches) {
            $this->boundAttributes = [];

            $attributes = $this->getAttributesFromAttributeString($matches['attributes']);

            return $this->componentString($matches[1], $attributes)."\n@endComponentClass##END-COMPONENT-CLASS##";
        }, $value);
    }

    public function componentClass(string $component)
    {
        $className = (
            collect(explode('.', $component))
                ->map(fn ($ns) => Str::ucfirst(Str::camel($ns)))
                ->join('\\')
        );

        if (class_exists($class = "\\App\\View\\Components\\{$className}")) {
            return $class;
        }

        if (class_exists($class = "\\Ja\\Livewire\\Blade\\{$className}")) {
            return $class;
        }

        if (view()->exists($view = "components.{$component}")) {
            return $view;
        }

        if (view()->exists($view = "ja-livewire::components.{$component}")) {
            return $view;
        }

        throw new InvalidArgumentException(
            "Unable to locate a class or view for component [{$component}]."
        );
    }
}
