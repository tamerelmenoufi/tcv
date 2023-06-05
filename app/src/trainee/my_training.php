<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?>

<style>
    .Titulo<?=$md5?>{
        margin-<?=(($_SESSION['lng'] == 'ar')?'right':'left')?>:60px;
    }
</style>

<div style="position:fixed; z-index:10; left:0; top:0; height:60px; background:#d8f2fe; width:100%; padding:10px; padding-top:15px;">
    <h4 class="Titulo<?=$md5?>"><?=$Dic['My trainings']?></h4>
</div>


<?php
    $query = "select
                        a.*,
                        c.name as training_name,
                        c.training_description as training_description,
                        b.name as company_name,
                        b.logo
                        from treinee_admission a
                        left join company b on a.company = b.id
                        left join company_training c on a.training = c.id
            where a.trainee = '{$_SESSION['AppUsuario']}' and del != '1'";
    $result = mysqli_query($con, $query);
    $i=0;
    while($d = mysqli_fetch_object($result)){
        $i++;
?>

<div class="card m-2 card-background OpenTraining" style="background">
    <div class="row g-0">
        <div class="col">
            <!-- <div class="card-body"> -->
                <h6 class="card-title p-2">
                    <?=$d->training_name?><br>
                    <small style="color:#a1a1a1"><?=$d->company_name?></small>
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
            <p class="card-text">
                <button class="btn btn-danger d-flex justify-content-between w-100" style="font-size:12px;">
                    <i class="fa-solid fa-sack-dollar"></i>
                    <span><?=$Dic['LE']?> <?=number_format($d->cost,2,'.',false)?> <?=$Dic['Cost']?></span>
                    <span><i class="fa-solid fa-user-xmark"></i></span>
                </button>
            </p>
        </div>
        </div>
    </div>
    <div class="row g-0">
        <div class="col">
            <p class="d-flex justify-content-between card-text p-2" style="color:#a1a1a1; font-size:12px;">
                <small class="text-body-secondary"><i class="fa fa-calendar"></i> <?=dataBr($d->initial_date)?> - <?=dataBr($d->final_date)?></small>
                <span><i class="fa fa-users"></i> 122 Vagas</span>
            </p>
        </div>
    </div>
    <div class="card-body">
        <p class="card-text" style="text-align:right">
            <span class="text-bg-warning rounded p-1">
                <i class="fa-solid fa-face-flushed"></i>
                <?=$Dic[$d->status]?>
            </span>
        </p>
        <p class="card-text" style="text-align:justify"><?=$d->training_description?></p>
    </div>
</div>

<?php
    }

