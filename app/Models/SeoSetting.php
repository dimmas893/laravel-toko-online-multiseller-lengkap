<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SeoSetting
 *
 * @property int $id
 * @property string $keyword
 * @property string $author
 * @property int $revisit
 * @property string $sitemap_link
 * @property string $description
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoSetting whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoSetting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoSetting whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoSetting whereRevisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoSetting whereSitemapLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeoSetting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SeoSetting extends Model
{
    //
}
