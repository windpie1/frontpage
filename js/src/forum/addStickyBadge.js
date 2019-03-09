import { extend } from 'flarum/extend';
import Model from 'flarum/Model';
import Discussion from 'flarum/models/Discussion';
import Badge from 'flarum/components/Badge';

Discussion.prototype.frontpage = Model.attribute('frontpage');

export default function addStickyBadge() {

  extend(Discussion.prototype, 'badges', function(badges) {
    if (this.frontpage()) {
      badges.add('frontpage', Badge.component({
        type: 'front',
        label: 'front',
        icon: 'fas fa-home'
      }), 10);
    }
  });
}