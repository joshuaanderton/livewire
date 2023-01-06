<?php

namespace Ja\Livewire\Support;

use Illuminate\View\Compilers\ComponentTagCompiler;
use InvalidArgumentException;
use Ja\Livewire\Livewire as JaLivewire;

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
        dd($component);

        // if ($class = JaLivewire::componentLookup($component)) {
        //     return $class;
        // }

        // if ($view = JaLivewire::viewLookup($component)) {
        //     return $view;
        // }

        throw new InvalidArgumentException(
            "Unable to locate a class or view for component [{$component}]."
        );
    }
}
