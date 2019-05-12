<div class="row text-center mb-4">

        <div class="col-12">
            <h1 class="mb-4 font-heading-primary">Showing All Agents</h1>
        </div>

        <div class="container">
            <div class="card-deck mx-auto">
                <?php
                    $index= 0;
                    $maxcard= 3;
                    foreach($top_agent as $key=>$value){
                        echo '
                        <div class="card o-hidden shadow-sm my-3 profile-card" style="width: 18rem;">
                            <div class="card-header"></div>
                            <div class="text-center mt-3">
                                <img src="'. base_url('assets/img/profile/') . $value['image'] .'" class="card-img-top w-50"
                                    alt="profile_pict">
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <h2 class="text-center font-weight-bold">'. $value['name'] .'</h2>
                                    <h5 class="text-center text-gray-500 mb-3">'. $value['headline'] .'</h5>
                                    <p class="text-center">Rating : '. $value['rating'] .'</p>
                                    <p class="text-center">Starting Bid : '. number_format(intval($value['starting_bid'])) .'</p>
                                </p>
                                <hr>
                                <div class="text-center mt-4"><a href="'. base_url('user/profile?id='.$value['id']) .'" class="btn btn-primary-custom px-4">Details</a></div>
                            </div>
                        </div>';

                        if($index==($maxcard-1)):
                            $index=0;
                            echo    '<div class="w-100 d-none d-md-block mt-4"></div>
                            ';
                        else:
                            $index++;
                        endif;
                    }

                    if($index!=0):
                        while($index!=$maxcard):
                            $index++;
                            echo    '<div class="card" style="border: none; background: none;"></div>';
                        endwhile;
                    endif;
                    
                    ?>
            </div>
        </div>

    </div>