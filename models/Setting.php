<?php

namespace app\models;

/**
 * This is the model class for table "admin".
 *
 * @property string $name
 * @property string $value
 * @property string $label
 * @property string $notes
 */
class Setting extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * Return name-value pair of settings by its name
     *
     * @param array $names
     * @return array
     */
    public static function getByNames($names)
    {
        $results = Setting::find()
            ->select(['value', 'name'])
            ->where(['name' => $names])
            ->indexBy('name')
            ->column();

        return $results;
    }

	/**
     * Return value of setting by its name
     *
     * @param string $name
     * @return string
     */
    public static function getValueByName($name)
    {
        $result = Setting::find()
            ->select('value')
            ->where(['name' => $name])
            ->limit(1)
            ->scalar();

        return $result;
    }
	
	/**
	 * return Company Address
	 * 
	 * @return string
	 */
	public static function getCompanyAddress()
	{
		return self::getValueByName('company_address');
	}
	
	/**
	 * return Company Email
	 * 
	 * @return string
	 */
	public static function getCompanyEmail()
	{
		return self::getValueByName('company_email');
	}
	
	/**
	 * return Company Name
	 * 
	 * @return string
	 */
	public static function getCompanyName()
	{
		return self::getValueByName('company_name');
	}
	
	/**
	 * return Company Phone
	 * 
	 * @return string
	 */
	public static function getCompanyPhone()
	{
		return self::getValueByName('company_phone');
	}
	
	/**
	 * return App Name
	 * 
	 * @return string
	 */
	public static function getAppName()
	{
		return self::getValueByName('app_name');
	}
	
	public static function getStructEntryFooter()
	{
		return self::getValueByName('struct_entry_footer');
	}
	
	public static function getStructExitFooter()
	{
		return self::getValueByName('struct_exit_footer');
	}
	
	public static function getCopyright()
	{
		return self::getValueByName('copyright');
	}
	
	public static function getSendMail()
	{
		return self::getValueByName('send_mail');
	}
}
