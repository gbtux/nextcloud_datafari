
<?php 
//var_dump($_['facets']['queries']);die;
?>
<div class="uk-container uk-container-large">
    <div class="uk-section">
        <div class="uk-width-expand@m uk-text-center" uk-grid>
            <div class="uk-width-expand">
                <div class="uk-card uk-card-default uk-card-body ">
                    <form>
                        <fieldset class="uk-fieldset">
                            <legend class="uk-legend">Recherche Datafari</legend>
                            <div class="uk-margin">
                                <div uk-form-custom style="width: 100%">
                                    <input id="imput-datafari-search" class="uk-input uk-form-large uk-form-width-large" type="text" placeholder="tapez votre recherche..." <?php if($_['term'] !== null) echo('value="' . $_['term']. '"');?>>
                                    <button id="btn-datafari-search" class="uk-button uk-button-primary uk-button-large" type="button" tabindex="-1" style="border-radius: inherit">Rechercher</button>
                                </div>        
                            </div>                
                        </fieldset>
                    </form>
                </div>
            </div>
            <!-- <div class="uk-width-1-3 uk-text-center" >
                <div class="uk-card uk-card-primary uk-card-body hidden preview">
                
                </div>
            </div> -->
        </div>
    </div>
    <div class="uk-section" style="padding-top:0">
        <?php if($_['term'] !== null) { 
            $baseURL = "/nextcloud/index.php/apps/datafari/?search=".$_['term']."&page=";
            ?>
            <ul class="uk-pagination" uk-margin>
                <?php if($_['currentPage'] > 1) { ?>
                    <li><a href="<?php p($baseURL).p($_['currentPage'] -1); ?>"><span uk-pagination-previous></span></a></li>
                <?php } ?>
                <?php   if($_['lastPage'] < 7 + ($_['adjacents'] * 2)) { 
                            for ($counter = 1; $counter <= $_['lastPage']; $counter++) {
                                if ($counter == $_['currentPage']) { ?> 
                                    <li class="uk-active"><span><?php p($counter); ?></span></li>                    
                                <?php }else{ ?>
                                    <li><a href="<?php p($baseURL).p($counter); ?>"><?php p($counter);?></a></li>                    
                                    <?php } 
                            }
                        }else{
                            if($_['currentPage'] < 1 + ($_['adjacents'] * 2)) {
                                for ($counter = 1; $counter < 4 + ($_['adjacents'] * 2); $counter++) {
                                    if ($counter == $_['currentPage']){ ?>
                                        <li class="uk-active"><span> <?php p($counter); ?></span></li>                    
                                    <?php }else{ ?>
                                        <li><a href="<?php p($baseURL).p($counter); ?>"> <?php p($counter); ?></a></li>                    
                                    <?php } 
                                } ?>
                                <li class="uk-disabled"><span>...</span></li>
                                <li><a href="<?php p($baseURL).p($_['lastPage']-1); ?>"><?php p($_['lastPage']-1);?></a></li>
                                <li><a href="<?php p($baseURL).p($_['lastPage']); ?>"><?php p($_['lastPage']);?></a></li>
                            <?php }elseif ($_['lastPage'] - ($_['adjacents'] * 2) > $_['currentPage'] && $_['currentPage'] > ($_['adjacents'] * 2)) { ?>
                                <li><a href="<?php p($baseURL) ?>1">1</a></li>
                                <li><a href="<?php p($baseURL) ?>2">2</a></li>
                                <li class="uk-disabled"><span>...</span></li>
                                <?php
                                    for ($counter = $_['currentPage'] - $_['adjacents']; $counter <= $_['currentPage'] + $_['adjacents']; $counter++)
                                    {
                                        if ($counter == $_['currentPage']) { ?>
                                            <li class="uk-active"><span> <?php p($counter); ?></span></li>
                                        <?php }else{ ?>
                                            <li><a href="<?php p($baseURL).p($counter); ?>"> <?php p($counter); ?></a></li>                    
                                        <?php }      
                                    }?>
                                    <li class="uk-disabled"><span>...</span></li>
                                    <li><a href="<?php p($baseURL).p($_['lastPage']-1); ?>"><?php p($_['lastPage']-1);?></a></li>
                                    <li><a href="<?php p($baseURL).p($_['lastPage']); ?>"><?php p($_['lastPage']);?></a></li>

                            <?php }else{ ?>
                                <li><a href="<?php p($baseURL) ?>1">1</a></li>
                                <li><a href="<?php p($baseURL) ?>2">2</a></li>
                                <li class="uk-disabled"><span>...</span></li>
                                <?php   for ($counter = $_['lastPage'] - (2 + ($_['adjacents'] * 2)); $counter <= $_['lastPage']; $counter++){
                                            if ($counter == $_['currentPage']) { ?>
                                                <li class="uk-active"><span> <?php p($counter); ?></span></li>
                                            <?php }else{ ?>
                                                <li><a href="<?php p($baseURL).p($counter); ?>"> <?php p($counter); ?></a></li>                    
                                            <?php }
                                        }
                            }
                    }    
                ?>
                <?php if($_['currentPage'] < $_['lastPage']) { ?>
                    <li><a href="<?php p($baseURL).p($_['currentPage'] + 1); ?>"><span uk-pagination-next></span></a></li>
                <?php } ?>
                <li class="uk-disabled" style="margin-left: auto"><span><?php p($_['totalDocs']);?> résultats</span></li>
            </ul>
        <?php } ?>
        <?php  if(count($_['results']) === 0) { ?>  
            <div class="uk-card uk-card-large uk-card-default uk-card-body" style="width: calc(100vw - 450px)">
                <h3 class="uk-card-title">Aucun résultat trouvé</h3>
            </div>
        <?php } ?>
        <?php foreach($_['results'] as $entry){ ?>
            <div class="uk-card uk-card-default uk-card-body" style="margin-bottom: 15px">
                <div class="uk-card-badge"> <!--  uk-label -->
                    <img src="/nextcloud/apps/datafari/img/widgets/extensions/<?php p($entry->extension); ?>.svg" style="width:48px;height:48px;">
                </div>
                <h3 class="uk-card-title">
                    <a class="uk-link-muted" href="<?php p($entry->url); ?>"><?php p($entry->title[0]); ?></a> 
                    <button style="margin-left: 10px" class="uk-button uk-button-danger uk-button-small show-resume">
                        <span uk-icon="icon: info"></span> 
                        <span class="tooltiptext"><?php p($entry->preview_content[0]); ?></span>
                    </button>
                </h3>
                <p><?php p(substr($entry->preview_content[0],0,200)); ?></p>
            </div>    
        <?php
            }
        ?>
    </div>
</div>
