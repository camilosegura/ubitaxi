<div class="row">
    <div class="span12">              

        <div class="form">
            <?php echo CHtml::beginForm('', 'post', array('class'=> 'form-signin')); ?>
            <h2>Ingrese</h2>
            <p class="note"><?php echo UserModule::t('Los campos con <span class="required">*</span> son obligatorios.'); ?></p>

            <?php echo CHtml::errorSummary($model); ?>

            <div class="row">
                <?php echo CHtml::activeLabelEx($model, 'username'); ?>
                <?php echo CHtml::activeTextField($model, 'username') ?>
            </div>

            <div class="row">
                <?php echo CHtml::activeLabelEx($model, 'password'); ?>
                <?php echo CHtml::activePasswordField($model, 'password') ?>
            </div>            

            <div class="row rememberMe">
                <?php echo CHtml::activeCheckBox($model, 'rememberMe'); ?>
                <?php echo CHtml::activeLabelEx($model, 'rememberMe'); ?>
            </div>

            <div class="row submit">
                <?php echo CHtml::submitButton(UserModule::t("Login"), array('class'=> 'btn-primary')); ?>
            </div>

            <?php echo CHtml::endForm(); ?>
        </div><!-- form -->
    </div>
</div>

<?php
$form = new CForm(array(
    'elements' => array(
        'username' => array(
            'type' => 'text',
            'maxlength' => 32,
        ),
        'password' => array(
            'type' => 'password',
            'maxlength' => 32,
        ),
        'rememberMe' => array(
            'type' => 'checkbox',
        )
    ),
    'buttons' => array(
        'login' => array(
            'type' => 'submit',
            'label' => 'Login',
        ),
    ),
        ), $model);
?>