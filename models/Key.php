<?php namespace Graffon\Graffauth\Models;

use Model;
use Flash;
use Ramsey\Uuid\Uuid;

/**
 * Model
 */
class Key extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    /**
     * @var array dates to cast from the database.
     */
    protected $dates = ['deleted_at'];

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'graffon_graffauth_api_keys';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'name' => 'required',
        'ip_address' => 'required',
    ];

    public function beforeCreate()
    {
        $this->api_key = bin2hex(random_bytes(32));
        $this->app_key = Uuid::uuid4()->toString();;
    }

    public function afterCreate() {
        Flash::success('API Key created successfully');
    }
}
