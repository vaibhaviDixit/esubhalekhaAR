
<div class="container my-5 col-sm-12 col-md-9 col-lg-6">
    <div class="card">
        <div class="card-header">
            <h4>Track Progress</h4>
        </div>
        <div class="card-body">
            <div class="progress mb-3">
                <div class="progress-bar p-2 bg-primary" role="progressbar" style="<?php echo "width:".$trackPercent."%;"; ?>" aria-valuenow="2" aria-valuemin="0" aria-valuemax="5">
                    <?php echo $completed."/".sizeof($tracks); ?> tasks completed
                </div>
            </div>



            <div class="accordion" id="progressAccordion">

                <?php 
                    
                    foreach ($tracks as $key => $value) {

                ?>
                <!-- Accordion 1 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?php echo explode(" ", $key)[0]; ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo explode(" ", $key)[0]; ?>" aria-expanded="true" aria-controls="<?php echo explode(" ", $key)[0]; ?>">


                            <?php 

                                if(count($value)==1){
                                    echo '<span class="tick-icon green-tick mx-2">&#10004;</span> ';
                                }
                                else{
                                    echo '<span class="tick-icon red-tick mx-2">&#10008;</span>';
                                } 
                            ?>

                             <?php   echo $key; 
                             ?>

                        </button>
                    </h2>
                    <div id="<?php echo explode(" ", $key)[0]; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo explode(" ", $key)[0]; ?>" data-bs-parent="#progressAccordion">
                        <div class="accordion-body">
                           
                                <?php 
                                   if(count($value)==1){
                                        echo '<p class="text-success">Done</p>';
                                   }else{
                                    ?>
                                     <span>Missing: </span>
                                        <ol>
                                    <?php
                                         $counter = 0;
                                            
                                            foreach ($value as $key1 => $value1) {
                                                if ($counter == 0) {
                                                    $counter++;
                                                    continue; // Skip the first iteration which contains path
                                                }
                                                echo "<li class='text-danger'>".$value1."</li>";
                                                $counter++;
                                            }
                                        
                                    ?>
                                        </ol>

                                    <?php 

                                        if($key=="Payment" && count($value)>1){
                                            if($completed == (sizeof($tracks)-1) ){
                                     ?>
                                            <a class="btn btn-sm btn-primary" href="<?php echo route('wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] .  '/checkout') . queryString(); ?>">Continue</a>

                                     <?php
                                            }else{


                                    ?>
                                        <a class="btn btn-sm btn-primary disabled" >Continue</a>
                                    <?php
                                            }
                                        }else{
                                    ?>

                                    <a class="btn btn-sm btn-primary" href="<?php echo route('wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] .'/'. $value[0]['path']) . queryString(); ?>">Continue</a>


                                <?php
                                        }
                                   }    
                                ?>
                        
                        </div>
                    </div>
                </div>

                 <?php     }  ?>
                

            </div>



        </div>
    </div>
</div>