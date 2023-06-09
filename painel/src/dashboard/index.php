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
            <small><?=$Dic['Trainees']?></small>
            <h1><?=$d->trainee?></h1>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-info text-center m-2" role="alert">
            <small><?=$Dic['Admission']?></small>
            <h1><?=$d->admission?></h1>
        </div>
    </div>
</div>


<div class="row g-0">
    <div class="col-md-6">
        <table style="border:0; padding:0; margin:0; width:100%;" border="1">
        <?php
            $query = "select count(*) as qt, b.name as company_name, (select count(*) from company_training) as total from company_training a left join company b on a.company = b.id group by a.company order by qt desc";
            $result = mysqli_query($con, $query);
            while($d = mysqli_fetch_object($result)){
        ?>
        <tr>
            <td><?=$d->company_name?></td>
            <td>
                <div style="height:25px; background-color:green; width:<?=number_format($d->qt*100/$d->total,0,false,false)?>%"></div>
            </td>
        </tr>
        <?php
            }

        ?>
        </table>
    </div>
    <div class="col-md-6">

    </div>
</div>


<script>
    $(function(){

        Carregando('none');


    })
</script>