<div class="hcf_box">
    <style scoped>
        .hcf_box{
            display: grid;
            grid-template-columns: max-content 1fr;
            grid-row-gap: 10px;
            grid-column-gap: 20px;
        }
        .hcf_field{
            display: contents;
        }
    </style>
    <p class="meta-options hcf_field">
        <label for="hcf_published_date">Published Date</label>
        <input id="hcf_published_date"
               type="date"
               name="hcf_published_date"
               value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'hcf_published_date', true ) ); ?>">
    </p>
    <p class="meta-options hcf_field">
        <label for="hcf_event">Option</label>
        <input id="hcf_event"
               type="text"
               name="hcf_event"
               value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'hcf_event', true ) ); ?>">
    </p>
</div>