<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AnalyticsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analytic_data',function (Blueprint $table){
            $table->bigIncrements('id');
//            $table->unsignedInteger('user_id')->references('id')->on('users');
            $table->unsignedInteger('practice_id')->index()->nullable();
            $table->string('provider', 100)->nullable();
            $table->string('Rendering_Provider', 100)->nullable();
            $table->string('Service_Location', 250)->nullable();
            $table->string('account_nbr', 50)->nullable();
            $table->string('Patient_Name', 100)->nullable();
            $table->date('Date_of_Service')->nullable();
            $table->date('Claim_BillDate')->nullable();
            $table->string('icd_1',10)->nullable();
            $table->string('icd_2',10)->nullable();
            $table->string('icd_3',10)->nullable();
            $table->string('icd_4',10)->nullable();
            $table->string('icd_5',10)->nullable();
            $table->string('icd_6',10)->nullable();
            $table->string('icd_7',10)->nullable();
            $table->string('icd_8',10)->nullable();
            $table->string('pos',50)->nullable();
            $table->string('cptcode',10)->index()->nullable();
            $table->string('Modifier',100)->nullable();
            $table->integer('units')->length(3)->nullable();
            $table->integer('Billed_Amount')->length(11)->nullable();
            $table->string('Primary_Insurance_Name',100)->index()->nullable();
            $table->string('Secondary_Insurance_Name',100)->index()->nullable();
            $table->decimal('Primary_Insurance_Allowance',10,2)->nullable();
            $table->decimal('Primary_Insurance_Payment',10,2)->nullable();
            $table->decimal('Primary_Contractual_Adjustment',10,2)->nullable();
            $table->date('Primary_PaymentDate_CheckDate')->nullable();
            $table->string('Primary_CheckNo_ReferenceNo',30)->nullable();
            $table->decimal('Secondary_Insurance_Payment',10,2)->nullable();
            $table->decimal('Secondary_Contractual_Adjustment',10,2)->nullable();
            $table->date('Secondary_PaymentDate')->nullable();
            $table->string('Secondary_CheckNo',30)->nullable();
            $table->decimal('Patient_Payment',10,2)->nullable();
            $table->date('Patient_PaymentDate')->nullable();
            $table->decimal('Insurance_Balance',10,2)->nullable();
            $table->decimal('Patient_Balance',10,2)->nullable();
            $table->decimal('Write_off',10,2)->nullable();
            $table->date('dateofbirth')->nullable();
            $table->timestamps();
            $table->string('cptcode_description')->nullable();
            $table->float('work_RVU')->nullable();
            $table->float('practice_RVU')->nullable();
            $table->float('malpractice_RVU')->nullable();
            $table->float('total_RVU')->nullable();
            $table->float('cptcode_amount')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analytic_data');

    }
}
