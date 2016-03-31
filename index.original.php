<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Minecraft Server Status</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <h1>Minecraft Server Status</h1>
    <?php
    $settings = parse_ini_file("settings.ini");
//    print_r($settings);
//    print('<hr>');
    ?>
    <?php foreach ($settings['servers'] as $index => $serverIP): ?>
        <?php $outputs = [];
        exec('python getMinecraftStatus.py ' . $serverIP, $outputs, $return_var);

        $info = json_decode($outputs[0], true);
//        print_r($info);
        ?>
        <?php if (isset($info['error']) || $return_var != 0): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-circle" style="color: red;"></i>&nbsp;<?php echo $serverIP; ?></h3>
                </div>
                <div class="panel-body">
                    <dl class="dl-horizontal">
                        <dt>IP:Port</dt>
                        <dd><?php echo $serverIP; ?></dd>
                    </dl>
                </div>
            </div>
        <?php else: ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-circle" style="color: green;"></i>&nbsp;<?php echo $serverIP; ?></h3>
                </div>
                <div class="panel-body">
                    <dl class="dl-horizontal">
                        <dt>IP:Port</dt>
                        <dd><?php echo $serverIP; ?></dd>
                        <dt>名稱</dt>
                        <dd><?php echo $info['description'] ?></dd>
                        <dt>版本</dt>
                        <dd><?php echo $info['version']['name'] ?></dd>
                        <dt>Player</dt>
                        <dd>
                            <?php echo $info['players']['online'] ?>&nbsp;/&nbsp;<?php echo $info['players']['max'] ?>
                            <br/>
                            <div class="panel-group" id="accordionPlayerList<?php echo $index ?>" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingPlayerList<?php echo $index ?>">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordionPlayerList<?php echo $index ?>" href="#collapsePlayerList<?php echo $index ?>" aria-expanded="true" aria-controls="collapsePlayerList<?php echo $index ?>">
                                                玩家清單
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapsePlayerList<?php echo $index ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingPlayerList<?php echo $index ?>">
                                        <div class="panel-body">
                                            <table class="table">
                                                <tbody>
                                                <?php foreach ($info['players']['sample'] as $player): ?>
                                                    <tr>
                                                        <td><?php echo $player['name'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </dd>
                        <dt>Mod List</dt>
                        <dd>
                            <div class="panel-group" id="accordionModList<?php echo $index ?>" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingModList<?php echo $index ?>">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordionModList<?php echo $index ?>" href="#collapseModList<?php echo $index ?>" aria-expanded="true" aria-controls="collapseModList<?php echo $index ?>">
                                                Mod List
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseModList<?php echo $index ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingModList<?php echo $index ?>">
                                        <div class="panel-body">
                                            <table class="table">
                                                <tbody>
                                                <?php foreach ($info['modinfo']['modList'] as $mod): ?>
                                                    <tr>
                                                        <td><?php echo $mod['modid'] ?></td>
                                                        <td><?php echo $mod['version'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        <?php endif; ?>
        <?php print('<hr>'); ?>
    <?php endforeach; ?>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>

