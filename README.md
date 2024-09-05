# Laravel AI Toolkit 🧠

Laravel AI Toolkit is a powerful package designed to seamlessly integrate AI models, such as OpenAI's GPT and AWS's Claude, into your Laravel application. With an easy-to-use interface, this toolkit empowers developers to effortlessly add AI-driven features to their projects.

## 🚀 Features

- Simple integration with OpenAI and AWS Claude.
- Configurable AI providers.
- Customizable query builder for AI models.
- Exception handling and error reporting.
- Support for multiple AI models and providers, with fallback capabilities.

## 📋 Requirements

- PHP 8.1 or higher
- Laravel 10.x to 11.x
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

# Default Provider
AI_DEFAULT_PROVIDER="claude"

# Claude AI Configuration
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
$prompt->addContent('What is the capital of France?')
       ->setModel('gpt-3.5-turbo')
       ->setMaxTokens(50);

$response = $prompt->execute();

echo $response; // Output will be the AI's response.
```

### Explanation:

- addContent('What is the capital of France?'): Sets the question content for the AI model to process.
- setModel('gpt-3.5-turbo'): Specifies the AI model to be used.
- setMaxTokens(50): Limits the response to a maximum of 50 tokens.
- execute(): Sends the request to the AI model and retrieves the response.

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

### Explanation:

- Prompt::query(): Creates a new query using the AIQueryBuilder class.
- setModel('anthropic.claude-v2'): Sets the AI model to be used.
- setMaxTokens(100): Limits the response to a maximum of 100 tokens.
- addContent('Tell me a joke'): Adds content to the request.
- execute(): Executes the query and retrieves the result.

### Using Different Models Example

You can use different AI models for different tasks:

```php
use Endritvs\LaravelAIToolkit\Models\Prompt;

// Using GPT model
$gptPrompt = new Prompt();
$gptPrompt->addContent('Explain quantum computing in simple terms.')
          ->setModel('gpt-3.5-turbo')
          ->setMaxTokens(150);

$gptResponse = $gptPrompt->execute();
echo 'GPT Response: ' . $gptResponse . PHP_EOL;

// Using Claude model
$claudePrompt = new Prompt();
$claudePrompt->addContent('What are the latest trends in web development?')
             ->setModel('anthropic.claude-v2')
             ->setMaxTokens(150);

$claudeResponse = $claudePrompt->execute();
echo 'Claude Response: ' . $claudeResponse . PHP_EOL;
```

### Explanation:

- Using GPT model:
  - addContent('Explain quantum computing in simple terms.'): Sets the content for GPT to explain.
  - setModel('gpt-3.5-turbo'): Specifies the GPT model to use.
  - setMaxTokens(150): Limits the response to 150 tokens.
  - execute(): Gets the response from GPT.

- Using Claude model:
  - addContent('What are the latest trends in web development?'): Sets the content for Claude to process.
  - setModel('anthropic.claude-v2'): Specifies the Claude model.
  - setMaxTokens(150): Limits the response to 150 tokens.
  - execute(): Gets the response from Claude.
  
### Using Fallback Providers Example

Specify a fallback provider to use if the primary provider fails:

```php
use Endritvs\LaravelAIToolkit\Models\Prompt;

$prompt = new Prompt();
$prompt->addContent('Summarize the latest news on AI technology.')
       ->setProvider('gpt')
       ->setModel('gpt-3.5-turbo')
       ->setMaxTokens(150)
       ->fallback('claude'); // Claude will be used if GPT fails

$response = $prompt->execute();

echo $response;

```

### Explanation:

- addContent('Summarize the latest news on AI technology.'): Sets the content for the request.
- setProvider('gpt'): Sets the primary provider to GPT.
- setModel('gpt-3.5-turbo'): Specifies the GPT model.
- setMaxTokens(150): Limits the response to 150 tokens.
- fallback('claude'): Configures Claude as the fallback provider if GPT fails.
- execute(): Executes the request, using the fallback provider if necessary.

### Set Provider Example

Manually set a different provider for the AI model:

```php
use Endritvs\LaravelAIToolkit\Models\Prompt;

$prompt = new Prompt();
$prompt->setProvider('claude') // Set a different provider
       ->addContent('Describe the principles of machine learning.')
       ->setModel('claude-v2')
       ->setMaxTokens(150);

$response = $prompt->execute();

echo $response; // The response from the specified provider.

```

### Explanation:
- setProvider('claude'): Manually sets the AI provider to Claude.
- addContent('Describe the principles of machine learning.'): Sets the content to be processed.
- setModel('claude-v2'): Specifies the Claude model.
- setMaxTokens(150): Limits the response to 150 tokens.
- execute(): Sends the request to the specified provider and retrieves the response.

### Advanced Query Builder Example

Dynamically build and execute more complex queries:

```php
use Endritvs\LaravelAIToolkit\Models\Prompt;

$response = Prompt::query()
    ->setModel('gpt-3.5-turbo')
    ->addContent('What are the implications of quantum computing?')
    ->setMaxTokens(200)
    ->execute();

echo $response; // Outputs the result based on the complex query.
```
### Explanation:

- setModel('gpt-3.5-turbo'): Sets the AI model to be used.
- addContent('What are the implications of quantum computing?'): Adds additional content to the request.
- setMaxTokens(200): Limits the response to 200 tokens.
- execute(): Executes the query and processes the response.

### Complete Example (Everything Included)

Combines all features into a comprehensive example, demonstrating both GPT and Claude models:

```php
use Endritvs\LaravelAIToolkit\Models\Prompt;

// Example using GPT-4
$prompt = new Prompt();
$prompt->addContent('Give a summary of the latest advancements in technology.')
       ->setModel('gpt-4')
       ->setMaxTokens(300)
       ->fallback('claude'); // Fallback to Claude if GPT-4 fails

$response = $prompt->execute();

echo $response; // Outputs the result from GPT-4 or Claude if GPT-4 fails.

// Example using Claude
$claudePrompt = new Prompt();
$claudePrompt->addContent('Discuss the impact of recent technological innovations on society.')
             ->setModel('claude-v2')
             ->setMaxTokens(300);

$claudeResponse = $claudePrompt->execute();

echo 'Claude Response: ' . $claudeResponse . PHP_EOL;

// Example using Query Builder
$response = Prompt::query()
    ->setModel('gpt-3.5-turbo')
    ->addContent('What is the future of artificial intelligence?')
    ->setMaxTokens(150)
    ->execute();

echo $response; // Outputs the result based on the complex query and fallback.

```

### Explanation:

### GPT-4 Example:

- addContent('Give a summary of the latest advancements in technology.'): Sets the content for GPT-4.
- setModel('gpt-4'): Specifies GPT-4 as the primary model.
- setMaxTokens(300): Limits the response to 300 tokens.
- fallback('claude'): Uses Claude as the fallback provider if GPT-4 fails.
- execute(): Executes the request, retrieving the response from GPT-4 or Claude.

### Claude Example:

- addContent('Discuss the impact of recent technological innovations on society.'): Sets the content for Claude.
- setModel('claude-v2'): Specifies Claude as the model.
- setMaxTokens(300): Limits the response to 300 tokens.
- execute(): Executes the request and retrieves the response from Claude.

### Query Builder Example:

- Prompt::query(): Creates a new query builder instance.
- setModel('gpt-3.5-turbo'): Specifies GPT-3.5 as the model for the query.
- addContent('What is the future of artificial intelligence?'): Adds additional content to the query.
- setMaxTokens(150): Limits the response to 150 tokens.
- execute(): Executes the query and retrieves the result based on the specified parameters.

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
