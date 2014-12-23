<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th class="info">
                    <form class="form-inline">
                        <div class="form-group">
                            Title &nbsp; <input type="text" class="input-sm form-control">
                            <button type="submit" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </div>
                    </form>
                </th>
                <th class="info">Season</th>
                <th class="info">Episode</th>
                <th class="info">Status</th>
                <th class="info">Links</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($series as $serie) { ?>
            <?php $status = Status::model()->findByPk($serie->status); ?>
            <tr id="<?php echo $serie->id; ?>" onmouseover="showQuickImage('<?php echo $serie->image; ?>', 'series')">
                <td><?php echo $serie->title; ?></td>
                <td>
                    <input id="S<?php echo $serie->id; ?>" 
                           type="number" 
                           value="<?php echo $serie->season; ?>" 
                           style="max-width: 50px;" 
                           onchange="updateSeason('<?php echo $serie->id; ?>')" />
                </td>
                <!--<td>
                    &nbsp;<button class="btn btn-xs btn-default">
                        <span class="fa fa-fw fa-plus-circle"></span>
                    </button>
                    <button class="btn btn-xs btn-default">
                        <span class="fa fa-fw fa-minus-circle"></span>
                    </button>
                </td>-->
                <td>
                   <input id="E<?php echo $serie->id; ?>" 
                          type="number" 
                          value="<?php echo $serie->episode; ?>" 
                          style="max-width: 50px;" 
                          onchange="updateEpisode('<?php echo $serie->id; ?>')" />
                </td>
                <!--<td>
                    &nbsp;<button class="btn btn-xs btn-default">
                        <span class="fa fa-fw fa-plus-circle"></span>
                    </button>
                    <button class="btn btn-xs btn-default">
                        <span class="fa fa-fw fa-minus-circle"></span>
                    </button>
                </td>-->
                <td class="<?php echo $status->css; ?>"><?php echo $status->description; ?></td>
                <td>
                    <?php if($serie->wikiLink != null) { ?>
                    <a target="_blank" href="<?php echo $serie->wikiLink; ?>"  class="btn btn-xs btn-default" >
                        <span class="fa fa-fw fa-wordpress"></span>
                    </a>
                    <?php } ?>
                    <!--<a href="<?php #echo $serie->wikiLink; ?>"  class="btn btn-xs btn-default" >
                        <span class="fa fa-fw fa-bolt"></span>
                    </a>-->
                    <?php if($serie->wikiLink != null) { ?>
                    <a target="_blank" href="<?php echo $serie->wikiLink; ?>"  class="btn btn-xs btn-default" >
                        <span class="fa fa-fw fa-facebook"></span>
                    </a>
                    <?php } ?>
                </td>
                <td>
                    <button class="btn btn-xs btn-danger" onclick="showModalBlock('body', true, 'deleteSerie(<?php echo $serie->id; ?>)');">
                        <span class="fa fa-fw fa-trash-o"></span>
                    </button>
                    <a href="/index.php/serie/details?id=<?php echo $serie->id; ?>" class="btn btn-xs btn-primary" >
                        <span class="fa fa-fw fa-info-circle"></span>
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
        