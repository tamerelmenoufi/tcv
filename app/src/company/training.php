<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    // for($i=0;$i<10;$i++){
        $query = "select a.*,
                         c.name as training_name,
                         c.training_description as training_description,
                         b.name as company_name,
                         b.logo,
                         (select id from treinee_admission where trainee = '{$_SESSION['AppUsuario']}' and training = a.training and treining_period = a.id and del != '1') as sign_up
                from treining_period a
                left join company b on a.company = b.id
                left join company_training c on a.training = c.id
                where a.id = '{$_POST['id']}'";
        $result = mysqli_query($con, $query);
        $i=0;
        $d = mysqli_fetch_object($result);
        $i++;


        if($_POST['action'] == 'sign_up'){
            $q = "insert into treinee_admission set
                                                company = '{$d->company}',
                                                training = '{$d->training}',
                                                trainee = '{$_SESSION['AppUsuario']}',
                                                treining_period = '{$d->id}',
                                                initial_date = '{$d->initial_date}',
                                                final_date = '{$d->final_date}',
                                                cost = '{$d->cost}'
                ";
            mysqli_query($con, $q);
            exit();
        }

?>
<style>
    .Titulo<?=$md5?>{
        margin-<?=(($_SESSION['lng'] == 'ar')?'right':'left')?>:60px;
    }
</style>
<div style="position:fixed; z-index:10; left:0; top:0; height:60px; background:#d8f2fe; width:100%; padding:10px; padding-top:15px;">
    <h4 class="Titulo<?=$md5?>"><?=$Dic['Training details']?></h4>
</div>
<div class="card m-2 card-background OpenTraining" style="background">
    <div class="row g-0">
        <div class="col">
            <!-- <div class="card-body"> -->
                <h6 class="card-title" style="color:#054f8c; padding:2px; margin:0;">
                    <?=$d->training_name?>
                    <!-- <br><small style="color:#a1a1a1"><?=$d->company_name?></small> -->
                </h6>
            <!-- </div> -->

        </div>
    </div>
    <div class="row g-0">
        <div class="col-2">
        <img src="img/<?=$i?>.png" class="img-fluid rounded-start w-100">
        </div>
        <div class="col-10">
        <div class="card-body">
            <b><?=$d->company_name?></b>
            <p class="d-flex justify-content-between card-text p-2" style="color:#054f8c; font-size:12px;">
                <small class="text-body-secondary">
                    <i class="fa fa-calendar"></i> <?=$Dic['Date']?>: <?=dataBr($d->initial_date)?> - <?=dataBr($d->final_date)?><br>
                    <i class="fa fa-users"></i> <?=$d->trainings?> <?=$Dic['Trained Opportunity']?><br><br>
                    <span class="bg-success p-1 text-dark bg-opacity-25 rounded">
                        <i class="fa-solid fa-sack-dollar"></i> <?=$Dic['LE']?> <?=number_format($d->cost,2,'.',false)?> <?=$Dic['Cost']?>
                    </span>
                </small>
            </p>
            <!-- <p class="card-text">
                <?php
                if($d->sign_up){
                ?>
                <button class="btn btn-success d-flex justify-content-between w-100" style="font-size:12px;">
                    <i class="fa-solid fa-sack-dollar"></i>
                    <span><?=$Dic['LE']?> <?=number_format($d->cost,2,'.',false)?> <?=$Dic['Cost']?></span>
                    <span><i class="fa-regular fa-thumbs-up"></i></span>
                </button>
                <?php
                }else{
                ?>
                <button class="btn btn-primary d-flex justify-content-between w-100 sign_up" style="font-size:12px;">
                    <i class="fa-solid fa-sack-dollar"></i>
                    <span><?=$Dic['LE']?> <?=number_format($d->cost,2,'.',false)?> <?=$Dic['Cost']?></span>
                    <span><i class="fa-solid fa-right-to-bracket"></i></span>
                </button>
                <?php
                }
                ?>
            </p> -->
        </div>
        </div>
    </div>
    <div class="row g-0">
        <div class="col">
            <!-- <p class="d-flex justify-content-between card-text p-2" style="color:#a1a1a1; font-size:12px;">
                <small class="text-body-secondary"><i class="fa fa-calendar"></i> <?=dataBr($d->initial_date)?> - <?=dataBr($d->final_date)?></small>
                <span><i class="fa fa-users"></i> 122 Vagas</span>
            </p> -->

        </div>
    </div>
    <div class="card-body">
        <p class="card-text p-2" style="text-align:justify"><?=$d->training_description?></p>
    </div>
</div>

<script>
    $(function(){
        $(".sign_up").off('click').on('click', function(){
            AppUsusario = window.localStorage.getItem('AppUsusario');
            if(AppUsuario == 'undefined' || AppUsuario == null) AppUsuario = '';

            if(!AppUsuario){
                $.ajax({
                    url:`components/ms_popup.php`,
                    type:"POST",
                    data:{
                        local:'src/home/login.php',
                    },
                    success:function(dados){
                        $(".ms_corpo").append(dados);
                    }
                });
                return;
            }else{

                Carregando();
                $.ajax({
                    url:`src/company/training.php`,
                    type:"POST",
                    data:{
                        action:'sign_up',
                        id:'<?=$d->id?>'
                    },
                    success:function(dados){
                        $.ajax({
                            url:`components/ms_popup_100.php`,
                            type:"POST",
                            data:{
                                local:`src/company/training.php`,
                                id:'<?=$d->id?>'
                            },
                            success:function(dados){
                                PageClose();
                                $(".ms_corpo").append(dados);
                                Carregando('none');
                                $.alert('Inscrição realizada!');
                            }
                        });

                    }
                });

            }

        })
    })
</script>