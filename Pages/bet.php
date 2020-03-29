<?php
/**
 *
 * Template Name: Betting page
 *
 * The template for displaying all bets that use the custom post
 *
 */

get_header();

$loop = new WP_Query(array(
    'post_type' => 'betting',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'custom-bets',
            'field' => 'slug',
            'terms' => 'coming',
            // 'terms' => 'coming', 'active'),
        ),
    ),

)
);
 while ($loop->have_posts()): $loop->the_post();

//what sport
    $sport = get_field('pick_your_sport');

//Basketball comps
    $basketball_league = get_field('basketball');
    $nba = get_field('nba');
    $basketball_wc = get_field('basketball_wc');

//American football
    $nfl = get_field('nfl');

// Esports
    $esports = get_field('esports');

//Baseball
    $mlb = get_field('mlb');

//hockey comps
    $hockey_league = get_field('hockey');
    $nhl = get_field('nhl');
    $khl = get_field('khl');
    $Eishockey = get_field('Eishockey');
    $Eishockey2 = get_field('Eishockey2');

// Football teams
    $country = get_field('football');
    $eng = get_field('eng');
    $aus = get_field('aus');
    $bra = get_field('bra');
    $can = get_field('can');
    $bel = get_field('bel');
    $arg = get_field('arg');
    $chi = get_field('chi');
    $ger = get_field('ger');
    $ned = get_field('ned');
    $gre = get_field('gre');
    $jap = get_field('jap');
    $sco = get_field('scot');
    $rus = get_field('rus');
    $port = get_field('port');
    $swed = get_field('swed');
    $swss = get_field('swss');
    $ita = get_field('ita');
    $turk = get_field('turk');
    $amr = get_field('amr');
    $mex = get_field('mex');
    $dan = get_field('dan');
    $spa = get_field('spa');
    $fra = get_field('fra');

// Additions
    $time = get_field('game_time');
    $tip = get_field('tip');
    $rating = get_field('rate');
    $url = get_field('url');
    $odds = get_field('odds');
    $bookies = get_field('bookies');
    $tip_text = get_field('txt_tip', 101);
    $rate_text = get_field('txt_rating', 101);
    $bet_text = get_field('txt_bet', 101);
    $btn = get_field('button', 101);
    $updpown = get_field('underover');
    $goals = get_field('goals');
    
    ?>
<div class="single-bet--wrapper">

    <div class="level single-bet columns is-multiline is-mobile vcentered has-text-white is-relative">

        <div class="column is-3-desktop is-4-tablet is-full-mobile fade">
            <div class="level-left is-flex-mobile truncate">
                <?php extra_league_info(); ?>
            </div>
        </div>

        <div class='column is-3-desktop is-8-tablet is-full-mobile teams'>
            <?php //Show the game time ?>
            <div class="level is-relative">
                
                <div class="level-item team-badges is-flex team-color">
                <?php if ($sport == 'Football') {
                    
                    if ($country && in_array('England', $country)) {
                        complete_bet($eng);
                    }
                            
                    if ($country && in_array('America', $country)) {
                         complete_bet($amr);
                    }

                    if ($country && in_array('Mexico', $country)) {
                        complete_bet($mex);
                    }

                    if ($country && in_array('Danish', $country)) {
                         complete_bet($dan);
                    }

                    if ($country && in_array('Spain', $country)) {
                        complete_bet($spa);
                    }

                    if ($country && in_array('France', $country)) {
                        complete_bet($fra);
                    }

                    if ($country && in_array('Argentina', $country)) {
                        complete_bet($arg);
                    }

                    if ($country && in_array('Austrian', $country)) {
                        complete_bet($aus);
                    }

                    if ($country && in_array('Belgium', $country)) {
                        complete_bet($bel);
                    }

                    if ($country && in_array('Brazil', $country)) {
                        complete_bet($bra);
                    }

                    if ($country && in_array('Canada', $country)) {
                        complete_bet($can);
                    }

                    if ($country && in_array('China', $country)) {
                        complete_bet($chi);
                    }

                    if ($country && in_array('Germany', $country)) {
                        complete_bet($ger);
                    }

                    if ($country && in_array('Holland', $country)) {
                        complete_bet($ned);
                    }

                    if ($country && in_array('Greece', $country)) {
                        complete_bet($gre);
                    }

                    if ($country && in_array('Japan', $country)) {
                        complete_bet($jap);
                    }

                    if ($country && in_array('Russia', $country)) {
                        complete_bet($rus);
                    }

                    if ($country && in_array('Turkish', $country)) {
                        complete_bet($turk);
                    }

                    if ($country && in_array('Sweden', $country)) {
                        complete_bet($swed);
                    }

                    if ($country && in_array('Swiss', $country)) {
                        complete_bet($swss);
                    }

                    if ($country && in_array('Scotland', $country)) {
                        complete_bet($sco);
                    } 

                    if ($country && in_array('Italy', $country)) {
                        complete_bet($ita);
                    }

                    if ($country && in_array('Portugal', $country)) {
                        complete_bet($port);
                    }

                } else if ($sport == 'Hockey') {

                    if ($hockey_league && in_array('NHL', $hockey_league)) {
                        complete_bet($nhl);
                    }

                    if ($hockey_league && in_array('KHL', $hockey_league)) {
                        complete_bet($khl);
                    }

                    if ($hockey_league && in_array('Deutsche Eishockey Liga', $hockey_league)) {
                        complete_bet($Eishockey);
                    }

                    if ($hockey_league && in_array('Deutsche Eishockey Liga 2nd Division', $hockey_league)) {
                        complete_bet($Eishockey2);
                    }

                } else if ($sport == 'Basketball') {

                    if ($basketball_league && in_array('NBA', $basketball_league)) {
                        complete_bet($nba);
                    }

                    if ($basketball_league && in_array('World cup', $basketball_league)) {
                        complete_bet($basketball_wc);
                     }

                } else if ($sport == 'American football') {

                    complete_bet($nfl);

                } else if ($sport == 'Baseball') {     
                    complete_bet($mlb);

                } else if ($sport == 'Esports') {     
                   
                    eteams();

                } ?>

                    <div class="has-text-grey has-text-weight-bold">
                        vs
                    </div>
                </div>
            </div>
        </div>

        <div class='column is-3-desktop is-5-tablet is-full-mobile'>
            <div class="columns is-mobile">
                <div class='column is-half'>
                    <?php //Add a bar for the tip tip ?>
                    <div class="level tip">
                        <div class='level-left'>
                            <div class='level-item is-block'>
                                <div class="is-block is-uppercase has-text-weight-bold title-color">
                                    <?php echo $tip_text;?>
                                 </div>
                                <div class="is-block has-text-primary vs-color has-text-weight-bold">
                                    <?php if ($updpown == 'Under') { ?>
                                        <i class="has-text-danger fas fa-chevron-down"></i>
                                    <?php } else if ($updpown == 'Over') { ?>
                                        <i class="has-text-primary fas fa-chevron-up"></i>
                                    <?php };
                                    echo $tip; ?>
                                    <?php //if ($goals) {
                                        //echo "goals";
                                    //} ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='column is-half'>
                        <div class="level rating">
                            <div class='level-item is-block-touch'>
                                <?php //Add a bar for bet game rating ?>
                                <div class="skill has-text-right-mobile">
                                    <div class="is-uppercase has-text-weight-bold ratings title-color">
                                    <?php echo $rate_text; ?>
                                    </div>
                                    <div class="level-item is-flex-mobile">
                                        <div class="has-text-grey subtitle-color">
                                            <?php echo $rating; ?>/10
                                        </div>
                                        <div class="rating-bar bar-background">
                                            <div class="rate-<?php echo $rating; ?>" style="width: <?php echo $rating; ?>0%">
                                            <span class="animate blue bar-foreground"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="column is-3-desktop is-7-tablet is-full-mobile">
            <? //Add the bookies ?>
            <div class="level">
                <div class='level-left is-flex-mobile'>
                    <div class="level-left is-marginless bookies">
                        <img class="spacer--right" src="<?php echo get_template_directory_uri(); ?>/betting/<?php echo $bookies?>.png" width="45px" height="auto" alt="">
                        <div class="is-block is-uppercase has-text-weight-bold title-color">
                            <?php echo $bet_text; ?>
                            <div class="is-block has-text-grey subtitle-color">
                                <?php echo $odds; ?>
                            </div>
                        </div>
                    </div>
                    <a class='is-uppercase has-text-weight-bold button--bookie' href="<?php echo $url; ?>" target="_blank"><?php echo $btn; ?></a>
                </div>
            </div>
        </div>

    </div>

</div>
<?php

endwhile;
wp_reset_query();

get_footer();