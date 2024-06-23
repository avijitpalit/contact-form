jQuery(function($){
    let fields = []
    $('#add-field-form').on('submit', function(e){
        e.preventDefault()
        const label = e.target.label.value
        const type = e.target.type.value
        // console.log(label, type);
        fields.push({
            label,
            type
        })
        // console.log(fields);
        updatePreview()
    })

    function updatePreview(){
        $('#fields-preview').html('')
        fields.forEach(field => {
            let tag = `<input type="text">`
            switch (field.type) {
                case 'textarea':
                    tag = `<textarea></textarea>`
                    break;
            
                default:
                    tag = `<input type="${ field.type }">`
                    break;
            }
            $('#fields-preview').append(`
                <div class="field-preview">
                    <label>${ field.label }</label>
                    ${ tag }
                </div>
            `)
        })
    }

    // Save form
    $('#save-form').on('click', function(){
        // console.log(fields);
        $.ajax({
            url: scf.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: { action: 'save_form', fields },
            success: function(res){
                console.log(res);
            },
            error: function(error){ console.log(error); }
        })
    })
})