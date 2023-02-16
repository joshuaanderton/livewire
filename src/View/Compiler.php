<?php declare (strict_types=1);

namespace LivewireKit\View;

use LivewireKit\Support\Blade;
use InvalidArgumentException;
use Illuminate\View\Compilers\ComponentTagCompiler;

abstract class Compiler extends ComponentTagCompiler
{
    abstract protected function tag(): string;

    final private function attributesPregReplace(string $pattern, string $value, ?bool $selfClosing = false)
    {
        return preg_replace_callback($pattern, function (array $matches) use ($selfClosing) {
            $this->boundAttributes = [];

            $attributes = $this->getAttributesFromAttributeString($matches['attributes']);
            
            $attributes = array_merge(
              is_array($attributes) ? $attributes : [],
              ['tagname' => "'" . $matches[1] . "'"]
            );

            return $this->componentString($matches[1], $attributes).($selfClosing ? "\n@endComponentClass##END-COMPONENT-CLASS##" : '');
        }, $value);
    }

    public function componentClass(string $component)
    {
        if ($found = Blade::lookup($component)) {
            return $found;
        }

        throw new InvalidArgumentException(
            "Unable to locate a class or view for component [{$component}]."
        );
    }

    protected function compileOpeningTags(string $value)
    {
        $pattern = "/
      <
        \s*
        {$this->tag()}
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

        return $this->attributesPregReplace(
            pattern: $pattern,
            value: $value
        );
    }

    /**
     * Compile the closing tags within the given string.
     *
     * @param  string  $value
     * @return string
     */
    protected function compileClosingTags(string $value)
    {
        return preg_replace("/<\/\s*{$this->tag()}*\s*>/", ' @endComponentClass##END-COMPONENT-CLASS##', $value);
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
        {$this->tag()}
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

        return $this->attributesPregReplace(
            pattern: $pattern,
            value: $value,
            selfClosing: true
        );
    }
}
