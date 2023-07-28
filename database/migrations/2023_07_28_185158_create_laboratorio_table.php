<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consultorio.laboratorio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha');
            $table->bigInteger('id_paciente');
            $table->text('ACIDO_URICO_SERICO')->nullable();
            $table->text('ASTO')->nullable();
            $table->text('BILIRUBINA_TOTAL_FRACCI')->nullable();
            $table->text('CALCIO_SERICO')->nullable();
            $table->text('COLESTEROL')->nullable();
            $table->text('CREATININA')->nullable();
            $table->text('CURVA_DE_TOLERANCIA_GLUC')->nullable();
            $table->text('DEPURACION_DE_CREATININA')->nullable();
            $table->text('EMBARAZO_EN_SANGRE')->nullable();
            $table->text('ENZIMA_CARDIACA_CK')->nullable();
            $table->text('ENZIMA_CARDIACA_CKMB')->nullable();
            $table->text('ENZIMA_CARDIACA_LDH')->nullable();
            $table->text('FOSFATASA_ACIDA')->nullable();
            $table->text('FOSFATASA_ALCALINA')->nullable();
            $table->text('FOSFORO')->nullable();
            $table->text('GLICEMIA')->nullable();
            $table->text('ACIDO_URICO_EN_ORINA')->nullable();
            $table->text('GRUPO_SANGUINEO')->nullable();
            $table->text('HDL_LDL')->nullable();
            $table->text('HECES')->nullable();
            $table->text('HEMATOLOGIA_COMPLETA')->nullable();
            $table->text('HIERRO')->nullable();
            $table->text('HIV')->nullable();
            $table->text('ORINA')->nullable();
            $table->text('PSA_TOTAL')->nullable();
            $table->text('PTT')->nullable();
            $table->text('PLAQUETAS')->nullable();
            $table->text('PROTEINA_C_REACTIVA')->nullable();
            $table->text('PROTEINAS_TOTAL_FRACCION')->nullable();
            $table->text('RA_TEST')->nullable();
            $table->text('ORINA')->nullable();
            $table->text('REL_CALCIO_CREATININA_EN')->nullable();
            $table->text('RETICULOCITOS')->nullable();
            $table->text('SANGRE_OCULTA_EN_HECES')->nullable();
            $table->text('TIEMPO_DE_PROTOMBINA')->nullable();
            $table->text('TIEMPO_SANGRIA_COAGULACION')->nullable();
            $table->text('TRANSAMINASA_TGO')->nullable();
            $table->text('TRANSAMINASA_TGP')->nullable();
            $table->text('TRANSAMINASA_TGOTGP')->nullable();
            $table->text('TRIGLICERIDOS')->nullable();
            $table->text('UREA')->nullable();
            $table->text('VDRL')->nullable();
            $table->text('VELOCIDAD_SED_GLOBULAR')->nullable();
            $table->text('VLDL')->nullable();
            $table->text('CALCIO_EN_ORINA')->nullable();
            $table->text('PROTEINURIA_EN_ORINA_24')->nullable();
            $table->text('TROPONINA')->nullable();
            $table->text('GASES_ARTERIALES')->nullable();
            $table->text('GASES_VENENOSOS')->nullable();
            $table->text('EMBARAZO_EN_ORINA')->nullable();
            $table->text('ELECTROLITOS')->nullable();
            $table->text('AMILASA')->nullable();
            $table->text('MAGNESIO')->nullable();
            $table->text('GRAM')->nullable();
            $table->text('CETONEMIA')->nullable();
            $table->text('DIGOXINA')->nullable();
            $table->text('T3')->nullable();
            $table->text('T4')->nullable();
            $table->text('TSH')->nullable();
            $table->text('T3LIBRE')->nullable();
            $table->text('T4LIBRE')->nullable();
            $table->text('FIBRINOGENO')->nullable();
            $table->text('RELUREA_REATININA_EN_O')->nullable();
            $table->text('REL_ACIDO_URICO_CREATININA')->nullable();
            $table->text('REL_FOSFORO_CREATININA')->nullable();
            $table->text('REL_AMILASA_CREATININA_E')->nullable();
            $table->text('UREA_EN_ORINA')->nullable();
            $table->text('PROTEINAS_EN_ORINA')->nullable();
            $table->text('FOSFORO_EN_ORINA')->nullable();
            $table->text('AMILASA_EN_ORINA')->nullable();
            $table->text('MAGNESIO_EN_ORINA')->nullable();
            $table->text('REL_PROTEINA_CREATININA')->nullable();
            $table->text('FROTIS_DE_SANGRE_PERIFERICO')->nullable();
            $table->text('DENGUE_DUO')->nullable();
            $table->text('ESTRADIOL')->nullable();
            $table->text('FSH')->nullable();
            $table->text('LH')->nullable();
            $table->text('PSA_LIBRE')->nullable();
            $table->text('ANTIGENO_DE_SUPERFICIE')->nullable();
            $table->text('CORE_TOTAL')->nullable();
            $table->text('CORE_M')->nullable();
            $table->text('TOXO_M')->nullable();
            $table->text('TOXO_G')->nullable();
            $table->text('GLICEMIA_POST_PRANDIAL')->nullable();
            $table->text('INSULINA_BASAL')->nullable();
            $table->text('HEMOGLOBINA_GLICOSILADA')->nullable();
            $table->text('TROPONINA_T')->nullable();
            $table->text('GANMAGLUTAMINA_GGT')->nullable();
            $table->text('DIMERO_D')->nullable();
            $table->text('MICROALBUMINURIA')->nullable();
            $table->text('PEPTIDO_NATRIURETICO')->nullable();
            $table->text('MIOGLOBINA')->nullable();
            $table->text('MONONUCLEOSIS_INFECCIOSA')->nullable();
            $table->text('HEPATITIS_B_CORE')->nullable();
            $table->text('HEPATITIS_B_SUPERFICIE')->nullable();
            $table->text('HEPATITIS_C_VIRUS_HCV')->nullable();
            $table->text('HELICOBACTER_PILORI')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultorio.laboratorio');
    }
};
