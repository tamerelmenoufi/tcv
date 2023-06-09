<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");


    $query = "SELECT
                    (select count(*) from company_training) as training,
                    (select count(*) from company) as company,
                    (select count(*) from trainee) as trainee,
                    (select count(*) from treinee_admission) as admission
            ";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);


?>


<div class="row g-0">
    <div class="col-md-3">
        <div class="alert alert-success text-center m-2" role="alert">
            <small><?=$Dic['Company']?></small>
            <h1><?=$d->company?></h1>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-danger text-center m-2" role="alert">
            <small><?=$Dic['Training']?></small>
            <h1><?=$d->training?></h1>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-warning text-center m-2" role="alert">
            <small><?=$Dic['Trainne']?></small>
            <h1><?=$d->trainne?></h1>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-info text-center m-2" role="alert">
            <small><?=$Dic['Admission']?></small>
            <h1><?=$d->admission?></h1>
        </div>
    </div>
</div>


<script>
    $(function(){

        Carregando('none');


    })
</script>