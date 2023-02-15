<?php declare (strict_types=1);

namespace Ja\Livewire\View\Components;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Ja\Livewire\Blade as Component;
use Ja\Livewire\Support\Helper as JL;

class Icon extends Component
{
    public string $name;

    public string $library;

    public string $type;

    public string $class;

    public bool $if;

    public ?string $svg = null;

    private array $types = [
        'heroicons' => [
            'solid',
            'outline',
            'mini',
        ],
        'fontawesome' => [
            'solid',
            'regular',
            'light',
            'thin',
            'duotone',
            'brands',
        ]
    ];

    private array $typeDefaults = [
        'heroicons' => 'solid',
        'fontawesome' => 'solid'
    ];

    private array $fontAwesomeIcons = [
        'brands' => ['42-group', '500px', 'accessible-icon', 'accusoft', 'adn', 'adversal', 'affiliatetheme', 'airbnb', 'algolia', 'alipay', 'amazon-pay', 'amazon', 'amilia', 'android', 'angellist', 'angrycreative', 'angular', 'app-store-ios', 'app-store', 'apper', 'apple-pay', 'apple', 'artstation', 'asymmetrik', 'atlassian', 'audible', 'autoprefixer', 'avianex', 'aviato', 'aws', 'bandcamp', 'battle-net', 'behance', 'bilibili', 'bimobject', 'bitbucket', 'bitcoin', 'bity', 'black-tie', 'blackberry', 'blogger-b', 'blogger', 'bluetooth-b', 'bluetooth', 'bootstrap', 'bots', 'btc', 'buffer', 'buromobelexperte', 'buy-n-large', 'buysellads', 'canadian-maple-leaf', 'cc-amazon-pay', 'cc-amex', 'cc-apple-pay', 'cc-diners-club', 'cc-discover', 'cc-jcb', 'cc-mastercard', 'cc-paypal', 'cc-stripe', 'cc-visa', 'centercode', 'centos', 'chrome', 'chromecast', 'cloudflare', 'cloudscale', 'cloudsmith', 'cloudversify', 'cmplid', 'codepen', 'codiepie', 'confluence', 'connectdevelop', 'contao', 'cotton-bureau', 'cpanel', 'creative-commons-by', 'creative-commons-nc-eu', 'creative-commons-nc-jp', 'creative-commons-nc', 'creative-commons-nd', 'creative-commons-pd-alt', 'creative-commons-pd', 'creative-commons-remix', 'creative-commons-sa', 'creative-commons-sampling-plus', 'creative-commons-sampling', 'creative-commons-share', 'creative-commons-zero', 'creative-commons', 'critical-role', 'css3-alt', 'css3', 'cuttlefish', 'd-and-d-beyond', 'd-and-d', 'dailymotion', 'dashcube', 'deezer', 'delicious', 'deploydog', 'deskpro', 'dev', 'deviantart', 'dhl', 'diaspora', 'digg', 'digital-ocean', 'discord', 'discourse', 'dochub', 'docker', 'draft2digital', 'dribbble', 'dropbox', 'drupal', 'dyalog', 'earlybirds', 'ebay', 'edge-legacy', 'edge', 'elementor', 'ello', 'ember', 'empire', 'envira', 'erlang', 'ethereum', 'etsy', 'evernote', 'expeditedssl', 'facebook-f', 'facebook-messenger', 'facebook', 'fantasy-flight-games', 'fedex', 'fedora', 'figma', 'firefox-browser', 'firefox', 'first-order-alt', 'first-order', 'firstdraft', 'flickr', 'flipboard', 'fly', 'font-awesome', 'fonticons-fi', 'fonticons', 'fort-awesome-alt', 'fort-awesome', 'forumbee', 'foursquare', 'free-code-camp', 'freebsd', 'fulcrum', 'galactic-republic', 'galactic-senate', 'get-pocket', 'gg-circle', 'gg', 'git-alt', 'git', 'github-alt', 'github', 'gitkraken', 'gitlab', 'gitter', 'glide-g', 'glide', 'gofore', 'golang', 'goodreads-g', 'goodreads', 'google-drive', 'google-pay', 'google-play', 'google-plus-g', 'google-plus', 'google-wallet', 'google', 'gratipay', 'grav', 'gripfire', 'grunt', 'guilded', 'gulp', 'hacker-news', 'hackerrank', 'hashnode', 'hips', 'hire-a-helper', 'hive', 'hooli', 'hornbill', 'hotjar', 'houzz', 'html5', 'hubspot', 'ideal', 'imdb', 'instagram', 'instalod', 'intercom', 'internet-explorer', 'invision', 'ioxhost', 'itch-io', 'itunes-note', 'itunes', 'java', 'jedi-order', 'jenkins', 'jira', 'joget', 'joomla', 'js', 'jsfiddle', 'kaggle', 'keybase', 'keycdn', 'kickstarter-k', 'kickstarter', 'korvue', 'laravel', 'lastfm', 'leanpub', 'less', 'line', 'linkedin-in', 'linkedin', 'linode', 'linux', 'lyft', 'magento', 'mailchimp', 'mandalorian', 'markdown', 'mastodon', 'maxcdn', 'mdb', 'medapps', 'medium', 'medrt', 'meetup', 'megaport', 'mendeley', 'meta', 'microblog', 'microsoft', 'mix', 'mixcloud', 'mixer', 'mizuni', 'modx', 'monero', 'napster', 'neos', 'nfc-directional', 'nfc-symbol', 'nimblr', 'node-js', 'node', 'npm', 'ns8', 'nutritionix', 'octopus-deploy', 'odnoklassniki', 'old-republic', 'opencart', 'openid', 'opera', 'optin-monster', 'orcid', 'osi', 'padlet', 'page4', 'pagelines', 'palfed', 'patreon', 'paypal', 'perbyte', 'periscope', 'phabricator', 'phoenix-framework', 'phoenix-squadron', 'php', 'pied-piper-alt', 'pied-piper-hat', 'pied-piper-pp', 'pied-piper', 'pinterest-p', 'pinterest', 'pix', 'playstation', 'product-hunt', 'pushed', 'python', 'qq', 'quinscape', 'quora', 'r-project', 'raspberry-pi', 'ravelry', 'react', 'reacteurope', 'readme', 'rebel', 'red-river', 'reddit-alien', 'reddit', 'redhat', 'renren', 'replyd', 'researchgate', 'resolving', 'rev', 'rocketchat', 'rockrms', 'rust', 'safari', 'salesforce', 'sass', 'schlix', 'screenpal', 'scribd', 'searchengin', 'sellcast', 'sellsy', 'servicestack', 'shirtsinbulk', 'shopify', 'shopware', 'simplybuilt', 'sistrix', 'sith', 'sitrox', 'sketch', 'skyatlas', 'skype', 'slack', 'slideshare', 'snapchat', 'soundcloud', 'sourcetree', 'space-awesome', 'speakap', 'speaker-deck', 'spotify', 'square-behance', 'square-dribbble', 'square-facebook', 'square-font-awesome-stroke', 'square-font-awesome', 'square-git', 'square-github', 'square-gitlab', 'square-google-plus', 'square-hacker-news', 'square-instagram', 'square-js', 'square-lastfm', 'square-odnoklassniki', 'square-pied-piper', 'square-pinterest', 'square-reddit', 'square-snapchat', 'square-steam', 'square-tumblr', 'square-twitter', 'square-viadeo', 'square-vimeo', 'square-whatsapp', 'square-xing', 'square-youtube', 'squarespace', 'stack-exchange', 'stack-overflow', 'stackpath', 'staylinked', 'steam-symbol', 'steam', 'sticker-mule', 'strava', 'stripe-s', 'stripe', 'studiovinari', 'stumbleupon-circle', 'stumbleupon', 'superpowers', 'supple', 'suse', 'swift', 'symfony', 'teamspeak', 'telegram', 'tencent-weibo', 'the-red-yeti', 'themeco', 'themeisle', 'think-peaks', 'tiktok', 'trade-federation', 'trello', 'tumblr', 'twitch', 'twitter', 'typo3', 'uber', 'ubuntu', 'uikit', 'umbraco', 'uncharted', 'uniregistry', 'unity', 'unsplash', 'untappd', 'ups', 'usb', 'usps', 'ussunnah', 'vaadin', 'viacoin', 'viadeo', 'viber', 'vimeo-v', 'vimeo', 'vine', 'vk', 'vnv', 'vuejs', 'watchman-monitoring', 'waze', 'weebly', 'weibo', 'weixin', 'whatsapp', 'whmcs', 'wikipedia-w', 'windows', 'wirsindhandwerk', 'wix', 'wizards-of-the-coast', 'wodu', 'wolf-pack-battalion', 'wordpress-simple', 'wordpress', 'wpbeginner', 'wpexplorer', 'wpforms', 'wpressr', 'xbox', 'xing', 'y-combinator', 'yahoo', 'yammer', 'yandex-international', 'yandex', 'yarn', 'yelp', 'yoast', 'youtube', 'zhihu']
    ];

    protected bool $xs;

    protected bool $sm;

    protected bool $md;

    protected bool $lg;

    public function __construct(
        string $name,
        string $library = null,
        string $type = null,
        string $class = null,
        bool $if = null,
        bool $xs = null,
        bool $sm = null,
        bool $md = null,
        bool $lg = null
    ) {
        $this->if = $if === null ? true : $if;

        if (! $this->if) {
            return;
        }

        $this->name = explode(' ', $name)[0];
        $this->class = "icon-{$this->name} ".($class ?: '');
        $this->xs = ! ! $xs;
        $this->sm = ! ! $sm;
        $this->md = ! ! $md;
        $this->lg = ! ! $lg;

        if ($library) {
            $this->library = $library;
            $this->type = $type ?: $this->typeDefaults[$this->library];
        } elseif ($this->hasFontAwesomeKeys()) {
            $this->library = 'fontawesome';
            $this->type = $type ?: $this->typeDefaults[$this->library];

            $this->translateFontAwesomeKeys();
        } else {
            $this->library = 'heroicons';
            $this->type = $type ?: $this->typeDefaults[$this->library];
        }

        // $this->validate();

        switch ($this->library) {
            case 'fontawesome':
                $this->class = "fa-{$this->type} fa-{$this->name} {$this->class}";

                break;
            case 'heroicons':
                $this->svg = $this->importSVG($this->name);
                $this->class = Arr::toCssClasses(array_merge(explode(' ', $this->class), [
                    'h-auto',
                    'w-2.5' => $this->xs,
                    'w-3.5' => $this->sm,
                    'w-4' => ! ($this->xs ?: $this->sm ?: $this->md ?: $this->lg),
                    'w-7' => $this->md,
                    'w-8' => $this->lg,
                    'inline-block',
                    'strike-current' => $this->type === 'outline',
                    'fill-current' => $this->type !== 'outline',
                ]));

                break;
        }
    }

    private function validate(): void
    {
        $libraryTypes = $this->getLibraryTypes();

        if (! $libraryTypes) {
            throw new Exception(
                "[{$this->library} is not a supported icon library (options are ".join(', ', array_keys($this->types)).")"
            );
        }

        if (! in_array($this->type, $libraryTypes)) {
            throw new Exception(
                "[{$this->type}] is not a supported {$this->library} icon type (options are ".join(', ', $libraryTypes).")"
            );
        }
    }

    private function importSVG(): string
    {
        $svg = JL::file(
            "components/icons/{$this->library}/{$this->type}/{$this->name}.svg"
        );

        if ($this->library === 'heroicons') {
            $svg = Str::remove('height="24"', $svg);
            $svg = Str::remove('width="24"', $svg);
            $svg = Str::remove('fill="none"', $svg);
            $svg = Str::replace('#0F172A', 'current', $svg);
        }

        return $svg;
    }

    private function hasFontAwesomeKeys(): bool
    {
        // Check name attr for "fa-brands fa-rocket"...
        return (
            Str::startsWith($this->name, 'fa-') ||
            Str::contains($this->name, ' fa-')
        );
    }

    private function translateFontAwesomeKeys(): void
    {
        $types = $this->getLibraryTypes();
        $keys = (
            collect(explode(' ', $this->name))
                ->map(fn ($key) => trim(Str::remove('fa-', $key)) ?: null)
                ->whereNotNull()
        );

        $this->name = $keys->whereNotIn(null, $types)->first();

        $type = $keys->whereIn(null, $types)->first();

        if ($type) {
            $this->type = $type;

            return;
        }

        if (in_array($this->name, $this->fontAwesomeIcons['brands'])) {
            $this->type = 'brands';
        } else {
            $this->type = 'solid';
        }
    }

    private function getLibraryTypes(): array|null
    {
        return $this->types[$this->library] ?? null;
    }

    public function render()
    {
        if (! $this->if) {
            return '';
        }

        return match ($this->library) {
            'fontawesome' => <<<'blade'
                <i {{ $attributes->merge(compact('class')) }}></i>
            blade,

            'heroicons' => <<<'blade'
                <span {{ $attributes->merge(compact('class')) }}>{!! $svg !!}</span>
            blade,
        };
    }
}
