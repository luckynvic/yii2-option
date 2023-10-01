yii2-option
===
Yii2 extension to save named value pairs in database.

## Installation
Installation is recommended via composer by adding the following to the `require` section in your `composer.json`:
```json
"luckynvic/yii2-option": "*"
```
Run `composer update` afterwards.

Run migration following command:
```
	yii migrate --migrationPath="@luckynvic/option/migrations"
```

## Configuration
Modify your config

```php
    'components' => [
        'option' => ['class'=>'\luckynvic\option\components\OptionComponent'],
        ...
	]
```

## Usage
### Saving Option
```php
$state_list = [
	'O' => 'Open',
	'P' => 'On Progress',
	'C' => 'Complete',
	'A' => 'Cancel',
];
// save all array value
Yii::$app->option->set('state_list', $state_list);

// add new value or change value
Yii::$app->option->set('state_list', 'Failed', 'F');

// save single value
Yii::$app->option->set('app_name', 'Application Name');
```
### Get Option
```php
// get all option list
$state_list = Yii::$app->option->get('state_list');
// get all option list with default if not available
$my_list = Yii::$app->option->get('my_list', null, ['this', 'is', 'my', 'list']);

// get only one value
$progress = Yii::$app->option->get('state_list', 'O');
```
**Note:** pass `null` as index will return entire list.

### Delete option
```php
// delete entire option
Yii::$app->option->delete('state_list'); // or Yii::$app->option->set('state_list', null);

// delete only one item
Yii::$app->option->delete('state_list', 'C'); // or Yii::$app->option->set('state_list', null, 'C');
```
**Note:** set value to `null` make item will be deleted.

### Context

This extension allow option save based on its context. ie option for User.
```php


class User extends  implements IdentityInterface
{
	// add trait
	use \luckynvic\option\traits\HasOption;

	// optional to configure context key
	protected function optionKey()
	{
		return 'user-'.$this->id;
	}

}

// usage in app
$model->findOne(1);
// get user background color for user, default blue
$color = $model->getOption('background', 'color', 'blue');

// set background color to red
$color = $model->getOption('background', 'red', 'color');

```



## Author
* Lucky Vic (luckynvic@gmail.com)