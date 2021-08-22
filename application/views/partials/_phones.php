<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css">
.drop{
  position: absolute;
  background-color: #fff;
  width: 94%;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.drop .s{
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.drop .s:hover {background-color: #ddd;}

.drops{
  position: absolute;
  background-color: #fff;
  width: 94%;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.drops .s{
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.drops .s:hover {background-color: #ddd;}


</style>
                                    <div class="form-group">
                                        <label class="control-label">Basic</label>
                                        <div class="row">
                                            <div class="col-12 col-sm-6 m-b-sm-15">
                                                <input id="brand" type="text" name="brand" class="form-control form-input" placeholder="Brand" required value="<?php if(isset($product->brand)){ echo $product->brand; }?>" oninput="get_autocomplete()" autocomplete="off">
                                                <ul id="brands" class="drop"></ul>
                                            </div>
                                            <div class="col-12 col-sm-6 m-b-sm-15">
                                                <input type="text" name="model" class="form-control form-input" placeholder="Model" required value="<?php if(isset($product->model)){ echo $product->model; }?>" id="model" oninput="get_autocomplete_models()" autocomplete="off">
                                                <ul id="models" class="drops"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Memory</label>
                                        <div class="row">
                                            <div class="col-12 col-sm-6 m-b-sm-15">
                                                <input type="text" name="ram" class="form-control form-input" placeholder="RAM" required value="<?php if(isset($product->ram)){ echo $product->ram; }?>">
                                            </div>
                                            <div class="col-12 col-sm-6 m-b-sm-15">
                                                <input type="text" name="memory" class="form-control form-input" placeholder="Internal Storage" required value="<?php if(isset($product->memory)){ echo $product->memory; }?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Display</label>
                                        <div class="row">
                                            <div class="col-12 col-sm-6 m-b-sm-15">
                                                <input type="color" name="color" class="form-control form-input" placeholder="Colour" required value="<?php if(isset($product->color)){ echo $product->color; }?>">
                                            </div>
                                            <div class="col-12 col-sm-6 m-b-sm-15">
                                                <input type="text" name="screen_size" class="form-control form-input" placeholder="Screen Size" required value="<?php if(isset($product->screen_size)){ echo $product->screen_size; }?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 m-b-sm-15">
                                                <input type="text" name="camera" class="form-control form-input" placeholder="Main Camera" required value="<?php if(isset($product->camera)){ echo $product->camera; }?>">
                                            </div>
                                            <div class="col-12 col-sm-6 m-b-sm-15">
                                                <input type="text" name="battery" class="form-control form-input" placeholder="Battery (mAh)" required value="<?php if(isset($product->battery)){ echo $product->battery; }?>">
                                            </div>
                                        </div>
                                    </div>
