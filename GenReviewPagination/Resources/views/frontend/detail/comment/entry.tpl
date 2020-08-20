{namespace name="frontend/detail/comment"}

<div class="review--entry{if $isLast} is--last{/if}{if $vote.answer} has--answer{/if}" itemprop="review" itemscope itemtype="http://schema.org/Review">
    <div class="entry--header">

        {$points = $vote.points}
        {$base = 5}
       
        {* Type *}
        {$isType='single'} 
        {if isset($type)}
            {$isType=$type}
        {/if}

        {$isBase=10} 
        {if isset($base)}
            {$isBase=$base}
        {/if}

        {$hasMicroData=true}
        {if isset($microData)}
            {$hasMicroData=$microData}
        {/if}
        {if $hasMicroData && $isType === 'aggregated' && $count === 0} 
            {$hasMicroData=false}
        {/if}

        {if $isType === 'single'}
            {$data='itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"'}
        {else}
            {$data='itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"'}
        {/if}

        {if isset($label)}
            {$hasLabel=$label}
        {/if}

        {if $isType === 'aggregated'}
            {$hasLabel=true}
        {else}
            {$hasLabel=false}
        {/if}

        <span class="product--rating"{if $hasMicroData} {$data}{/if}>
            {$average = $points / 2}
            {if $isBase == 5}
                {$average = $points}
            {/if}

            {if $hasMicroData}
                <meta itemprop="ratingValue" content="{$points}">
                <meta itemprop="worstRating" content="1">
                <meta itemprop="bestRating" content="{$isBase}">
                {if $isType === 'aggregated'}
                    <meta itemprop="ratingCount" content="{$count}">
                {/if}
            {/if}

            {* Stars *}
            {if $points != 0}
                {for $value=1 to 5}
                    {$cls = 'icon--star'}

                    {if $value > $average}
                        {$diff=$value - $average}

                        {if $diff > 0 && $diff <= 0.5}
                            {$cls = 'icon--star-half'}
                        {else}
                            {$cls = 'icon--star-empty'}
                        {/if}
                    {/if}

                    <i class="{$cls}"></i>
                {/for}
            {/if}

            {* Label *}
            {if $hasLabel && $count}
                <span class="rating--count-wrapper">
                    (<span class="rating--count">{$count}</span>)
                </span>
            {/if}
        </span>
        
        <span class="content--field" itemprop="author">{if $vote.name}{$vote.name}{else}{s name="DetailCommentAnonymousName"}{/s}{/if}</span>
        <strong class="content--label">{s name="DetailCommentInfoAt"}{/s}</strong>

        <meta itemprop="datePublished" content="{$vote.datum|date_format:'%Y-%m-%d'}">
        <span class="content--field">{$vote.datum|date:"DATE_MEDIUM"}</span>

    </div>
    <div class="entry--content">
        <h4 class="content--title" itemprop="name">
            {$vote.headline}
        </h4>

        <p class="content--box review--content" itemprop="reviewBody">
            {$vote.comment|nl2br}
        </p>
    </div>
</div>