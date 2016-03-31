<!DOCTYPE HTML>
<html lang="zh-Hant-TW">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Minecraft Server Status</title>

        <link rel="stylesheet" type="text/css" href="css/semantic.min.css">
    </head>
    <body>
        <?php
            // Get Setting & Data
            $settings = parse_ini_file("settings.ini");
            $serverIP = null;
            foreach ($settings['servers'] as $index => $serverIP);
            $outputs = [];
            exec('python getMinecraftStatus.py ' . $serverIP, $outputs, $return_var);
            $info = json_decode($outputs[0], true);

            // decode
            $name = $info['description'];
            $version = $info['version']['name'];
            $players = $info['players'];
            $modlist = $info['modinfo']['modList'];
            $serverErr = isset($info['error']) or $return_var != 0;

            echo '<pre>' . var_export($outputs, true) . '</pre>';
        ?>
        <div class="full height">
            <div class="ui container">
                <br>
                <div class="header center">
                    <!-- Header -->
                    <h1 class="ui center aligned header">Minecraft Server Status</h1>
                </div>
                <br>
                <div class="ui three column grid">
                    <div class="four wide column">
                        <!-- Server Info -->
                        <div class="ui list">
                            <div class="item">
                                <div class="header">名稱</div>
                                <?php echo $name; ?>
                            </div>
                        </div>
                    </div>
                    <div class="eight wide column">
                        <!-- Server Status -->
                        <?php if($serverErr):?>

                        <?php else:?>

                        <?php endif;?>
                        <!-- Server IP -->
                        <h3 class="ui center aligned header"><?php echo $serverIP; ?></h3>
                    </div>
                    <div class="four wide column">
                        <!-- Online Users -->
                        <?php if(!$serverErr): ?>
                            <div class="header">玩家數：
                                <?php echo $info['players']['online'] ?>&nbsp;/&nbsp;<?php echo $info['players']['max'] ?>
                            </div>
                            <?php if($info['players']['online'] > 0): ?>
                                <h3 class="header">玩家清單：</h3>
                                <div class="ui list">
                                    <?php foreach ($info['players']['sample'] as $player): ?>
                                        <div class="item"><?php echo $player['name'] ?></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div>
                                    目前沒有玩家上線！
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="footer">

                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
        <script src="js/semantic.min.js"></script>
    </body>
</html>