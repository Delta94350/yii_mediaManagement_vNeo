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
                <th class="info">Episode</th>
                <th class="info">Status</th>
                <th class="info">Links</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($mangas as $manga) { ?>
            <?php $status = Status::model()->findByPk($manga->status); ?>
            <tr id="<?php echo $manga->id; ?>" onmouseover="showQuickImage('<?php echo $manga->image; ?>', 'mangas')">
                <td><?php echo $manga->title; ?></td>
                <!--<td>
                    &nbsp;<button class="btn btn-xs btn-default">
                        <span class="fa fa-fw fa-plus-circle"></span>
                    </button>
                    <button class="btn btn-xs btn-default">
                        <span class="fa fa-fw fa-minus-circle"></span>
                    </button>
                </td>-->
                <td>
                   <input id="E<?php echo $manga->id; ?>" 
                          type="number" 
                          value="<?php echo $manga->episode; ?>" 
                          style="max-width: 50px;" 
                          onchange="updateEpisode('<?php echo $manga->id; ?>', true)" />
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
                    <?php if($manga->wikiLink != null) { ?>
                    <a target="_blank" href="<?php echo $manga->wikiLink; ?>"  class="btn btn-xs btn-default" >
                        <span class="fa fa-fw fa-wordpress"></span>
                    </a>
                    <?php } ?>
                    <!--<a href="<?php #echo $serie->wikiLink; ?>"  class="btn btn-xs btn-default" >
                        <span class="fa fa-fw fa-bolt"></span>
                    </a>-->
                    <?php if($manga->wikiLink != null) { ?>
                    <a target="_blank" href="<?php echo $manga->wikiLink; ?>"  class="btn btn-xs btn-default" >
                        <span class="fa fa-fw fa-facebook"></span>
                    </a>
                    <?php } ?>
                </td>
                <td>
                    <button class="btn btn-xs btn-danger" onclick="showModalBlock('body', true, 'deleteSerie(<?php echo $manga->id; ?>, true)');">
                        <span class="fa fa-fw fa-trash-o"></span>
                    </button>
                    <a href="/index.php/manga/details?id=<?php echo $manga->id; ?>" class="btn btn-xs btn-primary" >
                        <span class="fa fa-fw fa-info-circle"></span>
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
        