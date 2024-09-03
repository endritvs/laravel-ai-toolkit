# Laravel AI Toolkit 🧠

Laravel AI Toolkit is a powerful package designed to seamlessly integrate AI models, such as OpenAI's GPT and AWS's Claude, into your Laravel application. With an easy-to-use interface, this toolkit empowers developers to effortlessly add AI-driven features to their projects.

## 🚀 Features

- Simple integration with OpenAI and AWS Claude.
- Configurable AI providers.
- Customizable query builder for AI models.
- Exception handling and error reporting.
- Support for multiple AI models and providers.

## 📋 Requirements

- PHP 8.0 or higher
- Laravel 9.x to 11.x
- `openai-php/laravel` package
- `aws/aws-sdk-php` package

## 🛠️ Installation

To install the package, use Composer:

```bash
composer require endritvs/laravel-ai-toolkit
```

After installing the package, publish the configuration file:

```bash
php artisan vendor:publish --provider="Endritvs\LaravelAIToolkit\AIServiceProvider" --tag="config"
```

This will create a configuration file at `config/ai.php`.

## ⚙️ Configuration

### Environment Variables

Ensure that you set up the following environment variables in your `.env` file:

```env
# OpenAI Configuration
OPENAI_API_KEY=your-openai-api-key
GPT_MODEL="gpt-3.5-turbo"
GPT_MAX_TOKENS=4000

# Claude AI Configuration
AI_DEFAULT_PROVIDER="claude"
CLAUDE_MAX_TOKENS=6000
CLAUDE_MODEL="anthropic.claude-v2"

# AWS Configuration
AWS_ACCESS_KEY_ID=your-aws-access-key
AWS_SECRET_ACCESS_KEY=your-aws-secret-key
AWS_REGION=us-west-2
```

### Configuration File

The `config/ai.php` configuration file contains default settings for the package. You can customize these settings as needed:

```php
return [

    'default_provider' => env('AI_DEFAULT_PROVIDER', 'claude'),

    'providers' => [
        'gpt' => [
            'class' => \Endritvs\LaravelAIToolkit\Providers\GPTProvider::class,
            'model' => env('GPT_MODEL', 'gpt-3.5-turbo'),
            'max_tokens' => env('GPT_MAX_TOKENS', 4000),
        ],
        'claude' => [
            'class' => \Endritvs\LaravelAIToolkit\Providers\ClaudeProvider::class,
            'model' => env('CLAUDE_MODEL', 'anthropic.claude-v2'),
            'max_tokens' => env('CLAUDE_MAX_TOKENS', 6000),
            'region' => env('AWS_REGION', 'us-west-2'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ],
    ],

    'defaults' => [
        'temperature' => 0.7,
        'max_tokens' => 4000,
        'top_p' => 1.0,
    ],
];
```

## 💻 Usage

### Basic Usage Example

You can use the package to interact with AI models as follows:

```php
use Endritvs\LaravelAIToolkit\Models\Prompt;

$prompt = new Prompt();
$prompt->setContent('What is the capital of France?')
       ->setModel('gpt-3.5-turbo')
       ->setMaxTokens(50);

$response = $prompt->execute();

echo $response; // Output will be the AI's response.
```

### Query Builder Example

The query builder allows you to build queries for AI models:

```php
use Endritvs\LaravelAIToolkit\Models\Prompt;

$response = Prompt::query()
    ->setModel('anthropic.claude-v2')
    ->setMaxTokens(100)
    ->addContent('Tell me a joke')
    ->execute();

echo $response; // Output will be the AI's response.
```

### Customizing Providers

You can add custom AI providers by extending the `AIProvider` class and registering them in the `ai.php` configuration file:

```php
namespace Endritvs\LaravelAIToolkit\Providers;

use Endritvs\LaravelAIToolkit\Providers\AIProvider;

class CustomAIProvider extends AIProvider
{
    public function execute(array $attributes)
    {
        // Custom implementation
        return 'Custom AI response';
    }
}
```

Then, update the configuration to include your custom provider:

```php
'providers' => [
    'custom' => [
        'class' => \Endritvs\LaravelAIToolkit\Providers\CustomAIProvider::class,
        'model' => 'custom-model',
    ],
],
```

### Handling Exceptions

The package will throw exceptions if something goes wrong during the execution of the AI models. Make sure to handle these exceptions in your application:

```php
use Endritvs\LaravelAIToolkit\Models\Prompt;
use Exception;

try {
    $prompt = new Prompt();
    $response = $prompt->setContent('Tell me something interesting.')->execute();
    echo $response;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
```

## 🛠️ Contributing

Contributions are welcome! If you'd like to contribute to this package, please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/new-feature`).
3. Commit your changes (`git commit -m 'Add new feature'`).
4. Push to the branch (`git push origin feature/new-feature`).
5. Open a pull request.

## 🛡️ Security Vulnerabilities

If you discover a security vulnerability within this package, please send an email to [endritsaiti8@gmail.com]. All security vulnerabilities will be promptly addressed.

## 📄 License

This package is licensed under the MIT License. See the [LICENSE](https://github.com/endritvs/laravel-ai-toolkit?tab=MIT-1-ov-file) file for more information.

## 💡 Tips & Tricks

- Use environment-specific configuration to tweak AI model behavior depending on your deployment environment.
- Monitor the usage and response times of your AI models to optimize performance.
- Experiment with different AI models to find the one that best suits your application's needs.

## 📬 Support

If you have any questions or need further assistance, feel free to reach out via email or open an issue on GitHub.
