<div class="row">
    <h1>Crear Coordinador</h1>
    <div class="form span4">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'user-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
                ));
        ?>

        <p class="note"><?php echo UserModule::t('Campos con <span class="required">*</span> son requeridos.'); ?></p>

        <?php echo $form->errorSummary(array($model)); ?>

        <div >
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username', array('size' => 20, 'maxlength' => 20)); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>

        <div >
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 128)); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>

        <div >
            <?php echo $form->labelEx($model, 'email'); ?>
            <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 128)); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>
        <div >
            <label for="Profile_firstname" class="required">Nombre <span class="required">*</span></label>
            <input size="60" maxlength="50" name="Profile[firstname]" id="Profile_firstname" type="text" value="">
            <div class="errorMessage" id="Profile_firstname_em_" style="display:none"></div>
        </div>
        <div >
            <label for="Profile_lastname" class="required">Apellido <span class="required">*</span></label>
            <input size="60" maxlength="50" name="Profile[lastname]" id="Profile_lastname" type="text" value="">
            <div class="errorMessage" id="Profile_lastname_em_" style="display:none"></div>
        </div>

        <div>
            <?php echo CHtml::label('Empresas', 'empresa'); ?>
            <?php echo CHtml::dropDownList('empresa[]', '', $empresas, array('multiple' => 'multiple')); ?>            
        </div>

        <div class="buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save')); ?>
        </div>    


        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>
