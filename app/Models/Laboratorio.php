<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
    // use HasFactory;

    public $table = "consultorio.laboratorios";

    protected $fillable = ['fecha','id_paciente','ACIDO_URICO_SERICO','ASTO','BILIRUBINA_TOTAL_FRACCI','CALCIO_SERICO','COLESTEROL','CREATININA','CURVA_DE_TOLERANCIA_GLUC','DEPURACION_DE_CREATININA','EMBARAZO_EN_SANGRE','ENZIMA_CARDIACA_CK','ENZIMA_CARDIACA_CKMB','ENZIMA_CARDIACA_LDH','FOSFATASA_ACIDA','FOSFATASA_ALCALINA','FOSFORO','GLICEMIA','ACIDO_URICO_EN_ORINA','GRUPO_SANGUINEO','HDL_LDL','HECES','HEMATOLOGIA_COMPLETA','HIERRO','HIV','ORINA','PSA_TOTAL','PTT','PLAQUETAS','PROTEINA_C_REACTIVA','PROTEINAS_TOTAL_FRACCION','RA_TEST','ORINA','REL_CALCIO_CREATININA_EN','RETICULOCITOS','SANGRE_OCULTA_EN_HECES','TIEMPO_DE_PROTOMBINA','TIEMPO_SANGRIA_COAGULACION','TRANSAMINASA_TGO','TRANSAMINASA_TGP','TRANSAMINASA_TGOTGP','TRIGLICERIDOS','UREA','VDRL','VELOCIDAD_SED_GLOBULAR','VLDL','CALCIO_EN_ORINA','PROTEINURIA_EN_ORINA_24','TROPONINA','GASES_ARTERIALES','GASES_VENENOSOS','EMBARAZO_EN_ORINA','ELECTROLITOS','AMILASA','MAGNESIO','GRAM','CETONEMIA','DIGOXINA','T3','T4','TSH','T3LIBRE','T4LIBRE','FIBRINOGENO','RELUREA_REATININA_EN_O','REL_ACIDO_URICO_CREATININA','REL_FOSFORO_CREATININA','REL_AMILASA_CREATININA_E','UREA_EN_ORINA','PROTEINAS_EN_ORINA','FOSFORO_EN_ORINA','AMILASA_EN_ORINA','MAGNESIO_EN_ORINA','REL_PROTEINA_CREATININA','FROTIS_DE_SANGRE_PERIFERICO','DENGUE_DUO','ESTRADIOL','FSH','LH','PSA_LIBRE','ANTIGENO_DE_SUPERFICIE','CORE_TOTAL','CORE_M','TOXO_M','TOXO_G','GLICEMIA_POST_PRANDIAL','INSULINA_BASAL','HEMOGLOBINA_GLICOSILADA','TROPONINA_T','GANMAGLUTAMINA_GGT','DIMERO_D','MICROALBUMINURIA','PEPTIDO_NATRIURETICO','MIOGLOBINA','MONONUCLEOSIS_INFECCIOSA','HEPATITIS_B_CORE','HEPATITIS_B_SUPERFICIE','HEPATITIS_C_VIRUS_HCV','HELICOBACTER_PILORI'];

}
