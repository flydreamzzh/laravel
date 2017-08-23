# infyomlabs插件使用

官网：http://labs.infyom.com/laravelgenerator/docs/5.4/generator-options

教程：http://laravelacademy.org/post/3716.html 

从数据表生成代码：重点

php artisan infyom:scaffold $MODEL_NAME$ --fromTable --tableName=$TABLE_NAME$

有时候你不想要生成的文件直接存放在配置的目录下，而是在该目录的子目录下，比如后台相关的存放在admin子目录下，这样你就可以使用--prefix=admin选项：
php artisan infyom:scaffold $MODEL_NAME$ --prefix=admin

迁移生成器
php artisan infyom:migration $MODEL_NAME$

模型生成器
php artisan infyom:model $MODEL_NAME$

Repository生成器
php artisan infyom:repository $MODEL_NAME$

API控制器生成器
php artisan infyom.api:controller $MODEL_NAME$

API请求生成器
php artisan infyom.api:requests $MODEL_NAME$

测试用例生成器
php artisan infyom.api:tests $MODEL_NAME$

脚手架控制器生成器
php artisan infyom.scaffold:controller $MODEL_NAME$

脚手架请求生成器
php artisan infyom.scaffold:requests $MODEL_NAME$

视图生成器
php artisan infyom.scaffold:views $MODEL_NAME$
