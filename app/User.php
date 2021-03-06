<?php

namespace App;

use App\Http\Model\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property int $id 主键 员工ID【id】
 * @property int|null $agent_id 所属代理商ID
 * @property string|null $email 员工邮箱
 * @property string|null $phone 员工手机【emp_cellphone】
 * @property string|null $name 员工姓名【emp_name】
 * @property string|null $password 登录密码【passwod】
 * @property int|null $role_id 关联到角色表s_system_role
 * @property int|null $is_lock 是否锁定【is_lock】
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @property int|null $employee_id 员工ID(0)代表超级代理商
 * @property string|null $real_name 员工姓名【emp_name】
 * @property-read \App\Http\Model\Agent|null $agent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRealName($value)
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    const RoleAdmin = 1;
    static function encryptPassword($password)
    {
        return md5(md5(md5(md5($password))));
    }


    protected $table = "a_agent_emp";
    protected $guarded = ['id', 'create_time', 'updated_time'];
    protected $hidden = ['password'];

    //自定义passport 登陆用户名 id 可以改成其他字段
    public function findForPassport($username) {
        return $this->where('phone', $username)->first();
    }



    public function AauthAcessToken()
    {
        return $this->hasMany('\App\OauthAccessToken');
    }


    public function agent()
    {
        return $this->belongsTo('App\Http\Model\Agent');
    }

    public function role()
    {
        return $this->belongsTo('App\Http\Model\Role');
    }

    public function percentages()
    {
        return $this->hasMany('App\Http\Model\EmployeeProfitRateConfig', 'employee_id');
    }

    //是否是系统管理员
    public function isSystemAdmin()
    {
        return $this->role_id == Role::ROLE_ADMIN_SYSTEM;
    }
}
