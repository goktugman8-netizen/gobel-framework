<?php

namespace Gobel\Console;

class MakePolicyCommand extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'make:policy';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Create a new policy class';

    /**
     * Execute the command.
     *
     * @param array $args
     * @return int
     */
    public function handle(array $args): int
    {
        if (empty($args)) {
            $this->error('Please provide a policy name.');
            return 1;
        }

        $name = $args[0];
        $path = $this->app->basePath('app/Policies/' . $name . '.php');

        if (file_exists($path)) {
            $this->error("Policy [{$name}] already exists!");
            return 1;
        }

        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents($path, $this->stub($name));

        $this->info("Policy [{$name}] created successfully.");

        return 0;
    }

    protected function stub($name)
    {
        return <<<PHP
<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class {$name}
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  \$user
     * @return mixed
     */
    public function view(User \$user)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  \$user
     * @return mixed
     */
    public function create(User \$user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  \$user
     * @param  mixed  \$model
     * @return mixed
     */
    public function update(User \$user, \$model)
    {
        // return \$user->id === \$model->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  \$user
     * @param  mixed  \$model
     * @return mixed
     */
    public function delete(User \$user, \$model)
    {
        //
    }
}
PHP;
    }
}
