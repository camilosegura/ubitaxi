
<div data-role="page" id="addresfffses" data-theme="e"> 
    <div data-role="header" data-position="fixed">

        <h1>Mi Taxi</h1>

    </div> 
    <div data-role="content">
        <?php if (Yii::app()->user->hasFlash('registration')): ?>
            <div class="success">
                <?php echo Yii::app()->user->getFlash('registration'); ?>
            </div>
        <?php else: ?>

            <?php
            $form = $this->beginWidget('UActiveForm', array(
                'id' => 'registration-form',                
                'disableAjaxValidationAttributes' => array('RegistrationForm_verifyCode'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions' => array('enctype' => 'multipart/form-data', 'data-ajax'=> 'false'),
                    ));
            
            
            ?>

            <?php echo $form->errorSummary(array($model, $profile)); ?>
            
            <?php echo $form->textField($model, 'username', array('placeholder'=>$model->getAttributeLabel('username'))); ?>
            <?php echo $form->error($model, 'username'); ?>

            
            <?php echo $form->passwordField($model, 'password', array('placeholder'=>$model->getAttributeLabel('password'))); ?>
            <?php echo $form->error($model, 'password'); ?>
            <p class="hint">
                <?php echo UserModule::t("Minimal password length 4 symbols."); ?>
            </p>

            <?php echo $form->passwordField($model, 'verifyPassword', array('placeholder'=>$model->getAttributeLabel('verifyPassword'))); ?>
            <?php echo $form->error($model, 'verifyPassword'); ?>
            
            <?php echo $form->textField($model, 'email', array('placeholder'=>$model->getAttributeLabel('email'))); ?>
            <?php echo $form->error($model, 'email'); ?>


            <?php
            $profileFields = $profile->getFields();
            if ($profileFields) {
                foreach ($profileFields as $field) {
                    ?>
                    
                    <?php
                    if ($widgetEdit = $field->widgetEdit($profile)) {
                        echo $widgetEdit;
                    } elseif ($field->range) {
                        echo $form->dropDownList($profile, $field->varname, Profile::range($field->range));
                    } elseif ($field->field_type == "TEXT") {
                        echo$form->textArea($profile, $field->varname, array('rows' => 6, 'cols' => 50));
                    } else if ($field->field_type == "DATE") {
                        echo $form->dateField($profile, $field->varname, array('size' => 60, 'maxlength' => (($field->field_size) ? $field->field_size : 255)));
                    } else {
                        echo $form->textField($profile, $field->varname, array('size' => 60, 'maxlength' => (($field->field_size) ? $field->field_size : 255), 'placeholder'=>$profile->getAttributeLabel($field->varname)));
                    }
                    ?>
                    <?php echo $form->error($profile, $field->varname); ?>

                    <?php
                }
            }
            ?>
            <?php if (UserModule::doCaptcha('registration')): ?>

                <?php echo $form->labelEx($model, 'verifyCode'); ?>

                <?php $this->widget('CCaptcha'); ?>
                <?php echo $form->textField($model, 'verifyCode'); ?>
                <?php echo $form->error($model, 'verifyCode'); ?>

                <p class="hint"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
                    <br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>

            <?php endif; ?>

            <?php echo CHtml::submitButton(UserModule::t("Register")); ?>

            <?php $this->endWidget(); ?>
            <!-- form -->
        <?php endif; ?>
    </div> 
</div>
