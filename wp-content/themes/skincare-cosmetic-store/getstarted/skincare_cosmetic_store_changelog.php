<div class="wprev-changelog">
<?php
$skincare_cosmetic_store_entries = skincare_cosmetic_store_get_changelog_from_readme();

if ( ! empty( $skincare_cosmetic_store_entries ) ) :
    foreach ( $skincare_cosmetic_store_entries as $skincare_cosmetic_store_entry ) :
        $skincare_cosmetic_store_details = explode( "\n", trim( $skincare_cosmetic_store_entry[2] ) );
?>
    <details class="wprev-changelog__item">
        <summary><?php echo esc_html( 'v' . $skincare_cosmetic_store_entry[1] ); ?></summary>
        <ul>
            <?php foreach ( $skincare_cosmetic_store_details as $skincare_cosmetic_store_detail ) :
                $skincare_cosmetic_store_detail = trim( $skincare_cosmetic_store_detail );
                if ( ! empty( $skincare_cosmetic_store_detail ) ) : ?>
                    <li><?php echo esc_html( ltrim( $skincare_cosmetic_store_detail, '* ' ) ); ?></li>
            <?php endif; endforeach; ?>
        </ul>
    </details>
<?php
    endforeach;
else :
?>
    <p><?php esc_html_e( 'No changelog available.', 'skincare-cosmetic-store' ); ?></p>
<?php endif; ?>
</div>
