<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\UserEnterprise;
use common\models\CommonUtil;
use common\models\AutoFactory;


/**
 * Register form
 */
class FactorySettingForm extends Model
{
    public $name;
    public $short_name;
    public $province;
    public $city;
    public $address;
    public $postcode;
    public $telzone;
    public $telephone;
    public $mobile;
    public $fax;
    public $contact;
    

    public function rules()
    {
        return [
          
            [['name', 'short_name','province','city','address','postcode','mobile','contact'], 'required'],        
            //验证手机号
            ['mobile','match','pattern'=>'^[1][3-8]+\\d{9}$^','message'=>'请输入正确的手机号码'],
            [['mobile'], 'string','max'=>11, 'min'=>11, 'tooLong'=>'手机号不能大于11位', 'tooShort'=>'手机号不能小于11位'],
        
            
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '厂商名称',
            'short_name' => '厂商简称',
            'province' => '省份',
            'city' => '城市',
            'address' => '地址',
            'postcode' => '邮编',
            'telzone' => '区号',
            'telephone' => '电话',
            'mobile' => '手机号',
            'fax' => '传真',
            'contact' => '联系人',
            'created_at' => '创建',
            'updated_at' => '更新',
        ];
    }
    /**
     * 注册
     *
     */
    public function create()
    {

        	$factory= new AutoFactory();
            $factory->factory_guid=CommonUtil::createUuid();
            $factory->name=$this->name;
            $factory->short_name=$this->short_name;
            $factory->province=$this->province;
            $factory->city=$this->city;
            $factory->address=$this->address;
            $factory->postcode=$this->postcode;
            $factory->telephone=$this->telephone;
            $factory->telzone=$this->telzone;
            $factory->mobile=$this->mobile;	       	
               
        	if($factory->save()){
        		    return true;
        		}       		       			     	       	
        	return false;
    }
}
