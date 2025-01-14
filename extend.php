<?php

/*
 * This file is part of fof/frontpage.
 *
 * Copyright (c) FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoF\FrontPage;

use Flarum\Api\Controller\ListDiscussionsController;
use Flarum\Api\Serializer\DiscussionSerializer;
use Flarum\Discussion\Discussion;
use Flarum\Discussion\Event\Saving;
use Flarum\Discussion\Filter\DiscussionFilterer;
use Flarum\Discussion\Search\DiscussionSearcher;
use Flarum\Extend;
use FoF\FrontPage\Gambits\FrontGambit;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/resources/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),
    new Extend\Locales(__DIR__.'/resources/locale'),

    (new Extend\Event())
        ->listen(Saving::class, Listeners\SaveFrontToDatabase::class),

    (new Extend\SimpleFlarumSearch(DiscussionSearcher::class))
        ->addGambit(FrontGambit::class),

    (new Extend\Filter(DiscussionFilterer::class))
        ->addFilter(FrontGambit::class),

    (new Extend\Model(Discussion::class))
        ->dateAttribute('frontdate'),

    (new Extend\ApiSerializer(DiscussionSerializer::class))
        ->attributes(Listeners\AddApiAttributes::class),

    (new Extend\ApiController(ListDiscussionsController::class))
        ->addSortField('frontdate'),
];
