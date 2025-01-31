<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('module', function (Blueprint $table) {
            $table->bigIncrements('iModuleId'); // Primary index, auto increment
            $table->string('vUniqueCode', 255)->nullable(); // Unique code, varchar(255)
            $table->integer('iRoleId')->nullable(); // Role ID, integer
            $table->integer('iMenuId')->nullable(); // Menu ID, integer
            $table->string('vModule', 255)->nullable(); // Module name, varchar(255)
            $table->string('vController', 255)->nullable(); // Controller name, varchar(255)
            $table->enum('eStatus', ['Pending', 'Active', 'Inactive'])->nullable(); // Status, enum('Pending', 'Active', 'Inactive')
            $table->integer('iOrder')->nullable(); // Order of the module, integer
            $table->enum('eFeature', ['Yes', 'No'])->nullable(); // Feature status, enum('Yes', 'No')
            $table->enum('eDelete', ['Yes', 'No'])->default('No'); // Delete status, enum('Yes', 'No')
            $table->dateTime('dtAddedDate')->nullable(); // Added date, datetime
            $table->dateTime('dtUpdatedDate')->nullable(); // Updated date, datetime

            // Add any necessary indexes
            $table->index('iRoleId');
            $table->index('iMenuId');
            $table->index('eStatus');
            $table->index('eFeature');
            $table->index('eDelete');
            $table->index('dtAddedDate');
            $table->index('dtUpdatedDate');
        });

        Schema::create('permission', function (Blueprint $table) {
            $table->bigIncrements('iPermissionId'); // Primary index, auto increment
            $table->string('vUniqueCode', 255)->nullable(); // Unique code, varchar(255)
            $table->bigInteger('iRoleId')->nullable(); // Role ID, bigint
            $table->integer('iModuleId')->nullable(); // Module ID, integer
            $table->enum('eRead', ['Yes', 'No'])->default('No'); // Read permission, enum('Yes', 'No')
            $table->enum('eWrite', ['Yes', 'No'])->default('No'); // Write permission, enum('Yes', 'No')
            $table->enum('eDelete', ['Yes', 'No'])->default('No'); // Delete permission, enum('Yes', 'No')
            $table->dateTime('dtAddedDate')->nullable(); // Added date, datetime
            $table->dateTime('dtUpdatedDate')->nullable(); // Updated date, datetime

            // Add indexes
            $table->index('iRoleId');
            $table->index('iModuleId');
            $table->index('eRead');
            $table->index('eWrite');
            $table->index('eDelete');
            $table->index('dtAddedDate');
            $table->index('dtUpdatedDate');
        });

        Schema::create('role', function (Blueprint $table) {
            $table->bigIncrements('iRoleId'); // Primary key, auto-increment
            $table->string('vUniqueCode', 255)->nullable(); // Unique code, varchar(255), nullable
            $table->string('vRole', 255)->nullable(); // Role name, varchar(255), nullable
            $table->string('vCode', 255)->nullable(); // Role code, varchar(255), nullable
            $table->enum('eStatus', ['Active', 'Inactive'])->default('Active'); // Status, enum('Active', 'Inactive')
            $table->enum('eDelete', ['Yes', 'No'])->default('No'); // Delete status, enum('Yes', 'No')
            $table->dateTime('dtAddedDate')->nullable(); // Added date, datetime, nullable
            $table->dateTime('dtUpdatedDate')->nullable(); // Updated date, datetime, nullable

            // Add indexes
            $table->index('vUniqueCode');
            $table->index('eStatus');
            $table->index('eDelete');
            $table->index('dtAddedDate');
            $table->index('dtUpdatedDate');
        });

        Schema::create('menu', function (Blueprint $table) {
            $table->bigIncrements('iMenuId'); // Primary key, auto-increment
            $table->string('vUniqueCode', 255)->nullable(); // Unique code, varchar(255), nullable
            $table->string('vMenu', 100)->nullable(); // Menu name, varchar(100), nullable
            $table->integer('iRoleId')->nullable(); // Role ID, integer, nullable
            $table->enum('eStatus', ['Active', 'Inactive', 'Pending'])->nullable(); // Status, enum('Active', 'Inactive', 'Pending')
            $table->string('vCode', 100)->nullable(); // Menu code, varchar(100), nullable
            $table->enum('eFeature', ['Yes', 'No'])->default('No'); // Feature status, enum('Yes', 'No')
            $table->integer('iOrder')->nullable(); // Order of the menu item, integer, nullable
            $table->enum('eDelete', ['No', 'Yes'])->default('No'); // Delete status, enum('No', 'Yes')
            $table->dateTime('dtAddedDate')->nullable(); // Added date, datetime, nullable
            $table->dateTime('dtUpdatedDate')->nullable(); // Updated date, datetime, nullable

            // Add indexes
            $table->index('vUniqueCode');
            $table->index('iRoleId');
            $table->index('eStatus');
            $table->index('vCode');
            $table->index('eFeature');
            $table->index('eDelete');
            $table->index('dtAddedDate');
            $table->index('dtUpdatedDate');
        });

        Schema::create('setting', function (Blueprint $table) {
            $table->increments('iSettingId'); // Primary key, auto-increment
            $table->string('vName', 255); // Setting name, varchar(255), not nullable
            $table->string('vDesc', 255); // Setting description, varchar(255), not nullable
            $table->text('vValue')->nullable(); // Setting value, text, nullable
            $table->integer('iSettingOrder')->nullable(); // Setting order, integer, nullable
            $table->enum('eConfigType', ['Company','Appearance','Email','Meta','SMTP','SMS','Preferences','Config','Authenticate','Social','Currency'])->nullable(); // Config type, enum with given values
            $table->enum('eDisplayType', ['text','selectbox','textarea','checkbox','hidden','editor','file','readonly','password'])->nullable(); // Display type, enum with given values
            $table->string('eSource', 255)->nullable(); // Source, varchar(255), nullable
            $table->text('vSourceValue')->nullable(); // Source value, text, nullable
            $table->enum('eStatus', ['Active', 'Inactive'])->default('Active'); // Status, enum('Active', 'Inactive')
            $table->dateTime('dtAddedDate')->nullable(); // Added date, datetime, nullable
            $table->dateTime('dtUpdatedDate')->nullable(); // Updated date, datetime, nullable

            // Add indexes
            $table->index('vName');
            $table->index('eConfigType');
            $table->index('eDisplayType');
            $table->index('eSource');
            $table->index('eStatus');
            $table->index('dtAddedDate');
            $table->index('dtUpdatedDate');
        });

        Schema::create('pagination', function (Blueprint $table) {
            $table->bigIncrements('iPaginationId'); // Primary key, auto-incrementing bigint
            $table->string('vUniqueCode', 255)->nullable()->index(); // Unique code, varchar(255), nullable
            $table->string('vController', 255)->nullable()->index(); // Controller name, varchar(255), nullable
            $table->string('vSize', 255)->nullable()->index(); // Size, varchar(255), nullable
            $table->enum('eStatus', ['Active', 'Inactive'])->nullable()->index(); // Status, enum('Active', 'Inactive'), nullable
            $table->enum('eDelete', ['Yes', 'No'])->default('No')->index(); // Deletion flag, enum('Yes', 'No'), default 'No'
            $table->dateTime('dtAddedDate')->nullable()->index(); // Added date, datetime, nullable
            $table->dateTime('dtUpdatedDate')->nullable()->index(); // Updated date, datetime, nullable
        });



        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('iUserId'); // Primary key, auto-incrementing bigint
            $table->string('vUniqueCode', 255)->nullable()->index(); // Unique code, nullable, indexed
            $table->bigInteger('iRoleId')->unsigned()->nullable()->index(); // Role ID, unsigned bigint, nullable, indexed
            $table->string('vFirstName', 255)->nullable(); // First name, varchar(255), nullable
            $table->string('vLastName', 255)->nullable(); // Last name, varchar(255), nullable
            $table->string('vImage', 255)->nullable(); // Image, varchar(255), nullable
            $table->string('vImageAlt', 255)->nullable(); // Image alt text, varchar(255), nullable
            $table->string('vWebpImage', 255)->nullable(); // WebP image, varchar(255), nullable
            $table->string('vEmail', 255)->nullable()->index(); // Email, varchar(255), nullable, indexed
            $table->string('vPassword', 255)->nullable()->index(); // Password, varchar(255), nullable, indexed
            $table->string('vPhone', 25)->nullable(); // Phone number, varchar(25), nullable
            $table->string('vAuthCode', 255)->nullable(); // Auth code, varchar(255), nullable
            $table->enum('eStatus', ['Active', 'Inactive', 'Pending'])->default('Active')->index(); // Status, enum, default 'Active', indexed
            $table->enum('eFeature', ['Yes', 'No'])->default('No')->index(); // Feature flag, enum, default 'No', indexed
            $table->enum('eDelete', ['Yes', 'No'])->default('No')->index(); // Delete flag, enum, default 'No', indexed
            $table->dateTime('dtAddedDate')->nullable()->index(); // Added date, datetime, nullable, indexed
            $table->dateTime('dtUpdatedDate')->nullable()->index(); // Updated date, datetime, nullable, indexed
        });

        Schema::create('meta', function (Blueprint $table) {
            $table->bigIncrements('iMetaId'); // Primary Index
            $table->string('vUniqueCode', 255)->nullable()->index(); // Index
            $table->enum('ePanel', ['Admin', 'Front'])->nullable()->index(); // Index
            $table->string('vTitle', 255)->nullable();
            $table->string('vController', 255)->nullable();
            $table->string('vMethod', 255)->nullable();
            $table->string('vSlug', 255)->nullable();
            $table->text('tKeyword')->nullable();
            $table->text('tDescription')->nullable();
            $table->enum('eStatus', ['Active', 'Inactive'])->default('Active')->index(); // Index
            $table->dateTime('dtAddedDate')->nullable();
        });


    }

    public function down()
    {
        Schema::dropIfExists('menu');
        Schema::dropIfExists('module');
        Schema::dropIfExists('permission');
        Schema::dropIfExists('pagination');
        Schema::dropIfExists('role');
        Schema::dropIfExists('setting');
        Schema::dropIfExists('users');
    }
};
