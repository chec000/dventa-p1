

<?php
    // no direct access
    defined('_JEXEC') or die; 

    $width = (100 / count($points)).'%';

    echo "<style>
        * {
            box-sizing: border-box;
        }

        .points-item {
            float: left;
            width: $width;
            padding: 10px;
            text-align: center;
        }

        .main-points:after {
          content: '';
          display: table;
          clear: both;
        }
    </style>";
?>
<div id="<?= $params->get('wrapper'); ?>" >
    <h2><?= JText::_('MOD_ACCOUNT_STATUS_FRONT_TPL_NAME'); ?></h2>

    <!-- USER INFORMATION -->
    <div class="account-status-header">
        <div class="account-status-avatar">
            <span class="fa fa-user-circle-o profile-user"></span>
        </div>

        <div class="account-status-userinfo">
            <?php
                foreach($user_info as $key => $info){
            ?>
            <<?= $params->get('headers_tag') ?>>
            <?php 
                echo $info['label']; 
            ?>
            </<?= $params->get('headers_tag'); ?>>
            <<?= $params->get('text_tag'); ?>>
            <?php 
                echo $info['value']; 
            ?>
            </<?= $params->get('text_tag'); ?>>
            <?php
                }
            ?>
        </div>
    </div>
    
    <!-- POINTS INFORMATION -->
    <div class="main-points">
        <?php
            $i = 1;
            $class = 'right-border';

            foreach($points as $key => $value){
                if($i == count($points)){
                    $class = '';
                }
        ?>
        <div class="points-item <?= $class ?>">
            <span class="points-number"><?= number_format($value, 0); ?></span><br>
            <span><?= $coin.' '.$key; ?></span>
        </div>
        <?php
                $i++;
            }
        ?>
    </div>

    <div class="account-status-canjes">
        <a href="index.php/historial-de-canje" class="btn btn-info"> Historial de canjes</a>
    </div>
</div>