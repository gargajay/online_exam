<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
  <div class="container-fluid pt-5 body_background">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="card card-primary">
               <div class="card-header">
                  <h4>Register</h4>
               </div>
                <div class="card-body " id="registration_form">
                  <?php echo form_open_multipart('', array('role'=>'form')); ?>
                  <?php // username ?>
                  <div class="row">
                     <div class="form-group col-12<?php echo form_error('username') ? ' has-error' : ''; ?>">
                        <?php echo form_label(lang('username'), 'username', array('class'=>'control-label')); ?>
                        <span class="required"> * </span>
                        <?php echo form_input(array('name'=>'username', 'id'=>'username','value'=>set_value('username', (isset($user['username']) ? $user['username'] : '')), 'class'=>'form-control')); ?>
                        <span class="small text-danger"> <?php echo strip_tags(form_error('username')); ?> </span>
                     </div>
                  </div>
                  <div class="row">
                     <?php // first name ?>    
                     <div class="form-group col-6<?php echo form_error('first_name') ? ' has-error' : ''; ?>">
                        <?php echo form_label(lang('front_first_name'), 'first_name', array('class'=>'control-label')); ?>
                        <span class="required">*</span>
                        <?php echo form_input(array('name'=>'first_name','id'=>'first_name', 'value'=>set_value('first_name', (isset($user['first_name']) ? $user['first_name'] : '')), 'class'=>'form-control')); ?>
                        <span class="small text-danger"> <?php echo strip_tags(form_error('first_name')); ?> </span>
                     </div>
                     <?php // last name ?>
                     <div class="form-group col-6<?php echo form_error('last_name') ? ' has-error' : ''; ?>">
                        <?php echo form_label(lang('front_last_name'), 'last_name', array('class'=>'control-label')); ?>
                        <span class="required">*</span>
                        <?php echo form_input(array('name'=>'last_name','id'=>'last_name', 'value'=>set_value('last_name', (isset($user['last_name']) ? $user['last_name'] : '')), 'class'=>'form-control')); ?>
                        <span class="small text-danger"> <?php echo strip_tags(form_error('last_name')); ?> </span>
                     </div>
                  </div>
                  

                  <div class="row">
                     <?php // email ?>
                     <div class="form-group col-6<?php echo form_error('email') ? ' has-error' : ''; ?>">
                        <?php echo form_label(lang('front_email'), 'email', array('class'=>'control-label')); ?>
                        <span class="required">*</span>
                        <?php echo form_input(array('name'=>'email', 'value'=>set_value('email', (isset($user['email']) ? $user['email'] : '')), 'class'=>'form-control', 'type'=>'email')); ?>
                        <span class="small text-danger"> <?php echo strip_tags(form_error('email')); ?> </span>
                     </div>
                     <?php // language ?>
                     <div class="form-group col-6<?php echo form_error('language') ? ' has-error' : ''; ?>">
                        <?php echo form_label(lang('front_language'), 'language', array('class'=>'control-label')); ?>
                        <span class="required">*</span>
                        <?php echo form_dropdown('language', $this->languages, (isset($user['language']) ? $user['language'] : $this->config->item('language')), 'id="language" class="form-control"'); ?>
                        <span class="small text-danger"> <?php echo strip_tags(form_error('language')); ?> </span>
                     </div>
                  </div>



                  <div class="row">

                    <?php // institutions ?>
                     <div class="form-group col-6<?php echo form_error('institution_id') ? ' has-error' : ''; ?>">
                        <?php echo form_label(lang('institutions'), 'institution_id', array('class'=>'control-label')); ?>
                        <span class="required">*</span>
                        <?php echo form_dropdown('institution_id', $all_institutions, NULL, 'id="institution_id" class="form-control"'); ?>
                        <span class="small text-danger"> <?php echo strip_tags(form_error('institution_id')); ?> </span>
                     </div>
                     

                    <?php //course   ?>
                    
                     <div class="form-group col-6<?php echo form_error('course_id') ? ' has-error' : ''; ?>">
                        <?php echo form_label(lang('course'), 'course_id', array('class'=>'control-label')); ?>
                        <span class="required">*</span>
                        <?php echo form_dropdown('course_id', $all_courses, NULL, 'id="course_id" class="form-control"'); ?>
                        <span class="small text-danger"> <?php echo strip_tags(form_error('course_id')); ?> </span>
                     </div>
                    
                  </div>





                  <div class="row">
                     <?php // password ?>
                     <div class="form-group col-6<?php echo form_error('password') ? ' has-error' : ''; ?>">
                        <?php echo form_label(lang('password'), 'password', array('class'=>'control-label')); ?>
                        <?php if ($password_required) : ?>
                           <span class="required">* </span>
                        <?php endif; ?>
                        <?php echo form_password(array('name'=>'password', 'value'=>'', 'class'=>'form-control', 'autocomplete'=>'off')); ?>
                        <span class="small text-danger"> <?php echo strip_tags(form_error('password')); ?> </span>
                     </div>
                     <?php // password repeat ?>
                     <div class="form-group col-6<?php echo form_error('password_repeat') ? ' has-error' : ''; ?>">
                        <?php echo form_label(lang('front_password_repeat'), 'password_repeat', array('class'=>'control-label')); ?>
                        <?php if ($password_required) : ?>
                           <span class="required">* </span>
                        <?php endif; ?>
                        <?php echo form_password(array('name'=>'password_repeat', 'value'=>'', 'class'=>'form-control', 'autocomplete'=>'off')); ?>
                        <span class="small text-danger"> <?php echo strip_tags(form_error('password_repeat')); ?> </span>
                     </div>
                     <?php if ( ! $password_required) : ?>
                        <div class="col-12 mb-3">
                           <span class="help-block text-warning"><?php echo lang('help_passwords'); ?></span>
                        </div>
                     <?php endif; ?>
                  </div>
                  

                  <div class="row">

                    <?php // front_upload_image ?>
                    <div class="form-group col-12 <?php echo form_error('front_upload_image') ? ' has-error' : ''; ?>">
                        <?php echo form_label(lang('front_upload_image'), 'user_image', array('class'=>'control-label')); ?>
                        <?php echo form_upload(array('name'=>'user_image','class'=>'form-control'));?>

                     </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-12 <?php echo form_error('front_upload_image') ? ' has-error' : ''; ?>">
                      <?php echo form_label(lang('are_you_a_tutor').' ?', 'tutor_request', array('class'=>'control-label')); ?><br/>
                      <?php echo form_checkbox(array('name'=>'tutor_request','class'=>'','value' => '1')); ?>
                    </div>
                  </div>


                  
                  
                  <!-- *********************************************************************************** -->
    
                  <div class="row">

                    <?php
                    if($customfields)
                    {
                      foreach ($customfields as $customfield) 
                      {
                        $value = isset($customfield->value) ? $customfield->value : NULL;
                        if($customfield->field_type=='input')
                        {
                            ?>
                            <div class="col-md-<?php echo $customfield->width; ?>">
                                <div class="form-group <?php echo form_error($customfield->field_name) ? ' has-error' : ''; ?>">
                                  <?php echo  render_input($customfield->field_name, $customfield->field_label,$value,'input'); ?>
                                  
                                </div>
                            </div>
                            <?php
                        }
                        else if($customfield->field_type=='email')
                        {

                            ?>
                            <div class="col-md-<?php echo $customfield->width; ?>">
                                <div class="form-group <?php echo form_error($customfield->field_name) ? ' has-error' : ''; ?>">
                                  <?php echo  render_input($customfield->field_name, $customfield->field_label,$value,'email'); ?>
                                  
                                </div>
                            </div>
                            <?php
                        }
                        else if($customfield->field_type=='phone')
                        {

                            ?>
                            <div class="col-md-<?php echo $customfield->width; ?>">
                                <div class="form-group <?php echo form_error($customfield->field_name) ? ' has-error' : ''; ?>">
                                  <?php echo  render_input($customfield->field_name, $customfield->field_label,$value,'tel'); ?>
                                  
                                </div>
                            </div>
                            <?php
                        }
                        else if($customfield->field_type=='date')
                        {

                            ?>
                            <div class="col-md-<?php echo $customfield->width; ?>">
                                <div class="form-group <?php echo form_error($customfield->field_name) ? ' has-error' : ''; ?>">
                                  <?php echo  render_input($customfield->field_name, $customfield->field_label,$value,'text','datepicker'); ?>
                                  
                                </div>
                            </div>
                            <?php
                        }
                        else if($customfield->field_type=='textarea')
                        {

                            ?>
                            <div class="col-md-<?php echo $customfield->width; ?>">
                                <div class="form-group <?php echo form_error($customfield->field_name) ? ' has-error' : ''; ?>">
                                  <?php echo  render_textarea($customfield->field_name, $customfield->field_label,$value); ?>
                                  
                                </div>
                            </div>
                            <?php

                        }
                        else if($customfield->field_type=='select')
                        {
                          $field_options = $customfield->field_options ? json_decode($customfield->field_options) : array();
                          $selected = $value;
                          $classes = '';
                            ?>
                            <div class="col-md-<?php echo $customfield->width; ?>">
                                <div class="form-group <?php echo form_error($customfield->field_name) ? ' has-error' : ''; ?>">
                                  <?php echo  render_select($customfield->field_name, $customfield->field_label,$field_options,$selected,$classes); ?>
                                  
                                </div>
                            </div>
                            <?php
                        }
                        else if($customfield->field_type=='checkbox')
                        {

                          $field_options = $customfield->field_options ? json_decode($customfield->field_options) : array();
                          $selected = $value ? json_decode($value) : [];
                          $classes = '';
                            ?>
                            <div class="col-md-<?php echo $customfield->width; ?>">
                                <div class="form-group <?php echo form_error($customfield->field_name.'[]') ? ' has-error' : ''; ?>">
                                  <?php echo  render_input($customfield->field_name, $customfield->field_label,$field_options,$selected,$classes); ?>
                                  <span class="small text-danger form-error"> <?php echo strip_tags(form_error($customfield->field_name.'[]')); ?> </span>
                                </div>
                            </div>
                            <?php
                        }
                        else if($customfield->field_type=='file')
                        {


                            ?>
                            <div class="col-md-<?php echo $customfield->width; ?>">
                                <div class="form-group <?php echo form_error($customfield->field_name) ? ' has-error' : ''; ?>">
                                  <?php echo  render_input($customfield->field_name, $customfield->field_label,$value,'file'); ?>
                                  <span class="small cf_image"><a target="_blank" href="<?php echo base_url('/assets/images/custom_fields/').$value ?>"><?php echo $value; ?></a></span>
                                </div>

                            </div>
                            <?php
                        }
                        else
                        {

                            ?>
                            <div class="col-md-<?php echo $customfield->width; ?>">
                                <div class="form-group <?php echo form_error($customfield->field_name) ? ' has-error' : ''; ?>">
                                  <?php echo  render_input($customfield->field_name, $customfield->field_label,$value,'input'); ?>
                                  <span class="small text-danger form-error"> <?php echo strip_tags(form_error($customfield->field_name.'[]')); ?> </span>
                                </div>
                            </div>
                            <?php

                        }

                      }
                    }
                    ?>

                  </div>

                  <!-- ********************************************************************************** -->
                  
                 
              

                <div class="row my-3">
                   
                      <div class="col-12 text-center">
                         
                         <?php 
                           if (!empty($this->settings->recaptcha_secret_key) && !empty($this->settings->recaptcha_site_key) && $this->settings->enable_captch_code_login == "YES") 
                           { ?>
                              <div class="g-recaptcha m-auto <?php echo form_error('g-recaptcha-response') ? ' has-error captch_error' : ''; ?>" data-sitekey="<?php echo $this->settings->recaptcha_site_key; ?>">
                                 
                              </div> 

                              <span class="small form-error"> <?php echo strip_tags(form_error('g-recaptcha-response')); ?> </span> 

                              <?php 
                           } ?>

                      </div>

                </div>

                <?php // buttons  ?>
                <div class="row ">
                   <div class="form-group col-12 mt-3"> 
                      <?php if ($this->session->userdata('logged_in')) : ?>
                         <button type="submit" name="submit" class="btn btn-block btn-success"><span class="glyphicon glyphicon-save"></span> <?php echo lang('core_button_save'); ?></button>
                         <?php else : ?>
                            <button type="submit" name="submit" class="btn btn-block btn-primary btn-lg"><?php echo lang('users_register'); ?></button>
                         <?php endif; ?>
                    </div>
                </div>

              <?php echo form_close(); ?> 
               </div>
              </div>     
            </div>
          </div>
        </div>

      </div>
  </div>

   <?php
      if ($this->session->userdata('logged_in')) : 
         if(uri_string() == 'user/register')
         {
            return redirect(base_url('profile'));
         }
      endif;
   ?>

