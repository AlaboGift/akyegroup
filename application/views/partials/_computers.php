<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
                                    <div class="form-group">
                                        <label class="control-label">Basic</label>
                                        <div class="row">
                                            <div class="col-12 col-sm-6 m-b-sm-15">
                                                <input type="text" name="brand" class="form-control form-input" placeholder="Brand" required value="<?php if(isset($product->brand)){ echo $product->brand; }?>">
                                            </div>
                                            <div class="col-12 col-sm-6 m-b-sm-15">
                                                <input type="text" name="model" class="form-control form-input" placeholder="Model" required value="<?php if(isset($product->model)){ echo $product->model; }?>">
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
                                                <input type="text" name="memory" class="form-control form-input" placeholder="Hard Drive" required value="<?php if(isset($product->memory)){ echo $product->memory; }?>">
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
                                                <input type="text" name="screen_size" class="form-control form-input" placeholder="Screen Resolution" required value="<?php if(isset($product->screen_size)){ echo $product->screen_size; }?>">
                                            </div>
                                        </div>
                                    </div>