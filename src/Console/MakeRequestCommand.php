<?php

namespace Gobel\Console;

class MakeRequestCommand extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'make:request';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Create a new form request class';

    /**
     * Execute the command.
     *
     * @param array $args
     * @return int
     */
    public function handle(array $args): int
    {
        if (empty($args)) {
            $this->error('Please provide a request name.');
            return 1;
        }

        $name = $args[0];
        $path = $this->app->basePath('app/Requests/' . $name . '.php');

        if (file_exists($path)) {
            $this->error("Request [{$name}] already exists!");
            return 1;
        }

        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents($path, $this->stub($name));

        $this->info("Request [{$name}] created successfully.");

        return 0;
    }

    protected function stub($name)
    {
        return <<<PHP
<?php

namespace App\Requests;

use Gobel\Http\Request;

class {$name} extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'title' => 'required|max:255',
        ];
    }
}
PHP;
    }
}
