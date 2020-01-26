'use strict';

var domElements = {};

function FormValidator(form) {

    this.form = form;
    this.allErrors = [];


}

FormValidator.prototype.checkRequired = function()
{
    let classThis = this ;
    this.form.find("[data-required]").each(function ()
    {
        let  value = $(this).val().trim();
        if (value == "")
        {
            classThis.allErrors.push({
                domElement : $(this),
                message : "Veuillez remplir ce champs",
            }) ;
        }
    });
}

FormValidator.prototype.checkRequiredSelect = function()
{
    let classThis = this ;

    this.form.find("[data-requiredselect]").each(function ()
    {
        let  value = $(this).val();
        let forbiddenValue = $(this).data("requiredselect") ;

        if (value == forbiddenValue)
        {
            classThis.allErrors.push({
                domElement : $(this),
                message : "Veuillez choisir une valeur",
            }) ;
        }
    });
}

/*----------------------------------------------------------------------------------------------------------------------*/
FormValidator.prototype.checkDataType = function()
{
    let classThis = this ;
    this.form.find("[data-type]").each(function ()
    {
        let  value = $(this).val().trim();
        let type = $(this).data("type");
        let optional = $(this).data("optional") ;
        switch (type)
        {
            case "float":
                if ( (optional && isNaN(value)) ||  (!optional && (value=="" || isNaN(value))) )
                {
                    classThis.allErrors.push({
                        domElement : $(this),
                        message : "Veuillez enter un nombre",
                    }) ;
                }
                break;

            case "integer":
                if ((optional && (isNaN(value) || value % 1 != 0)) ||(!optional &&  (value == "" || isNaN(value) || value % 1 != 0)) )
                {
                    classThis.allErrors.push({
                        domElement : $(this),
                        message : "Veuillez entrer un nombre entier",
                    }) ;
                }
                break;
        }

    });
}

/*-----------------------------------------------------------------------------------------------------------------------*/
FormValidator.prototype.checkMinLength = function()
{
    let classThis = this ;
    this.form.find("[data-minlength]").each(function ()
    {
        let  value = $(this).val().trim();
        let minLength = $(this).data("minlength") ;
        let missingChars = minLength - value.length ;

        if (value.length < minLength)
        {
            let message = "Veuillez entrer au moins "+minLength+" caractères<br>" ;
            message += "("+missingChars+" caractères manquants)" ;
            classThis.allErrors.push({
                domElement : $(this),
                message : message,
            }) ;
        }
    });
}

FormValidator.prototype.checkEmail = function()
{
    let classThis = this ;
    this.form.find("[data-email]").each(function ()
    {
        let  value = $(this).val().trim();

        if (! value.match(/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i ))
        {
            classThis.allErrors.push({
                domElement : $(this),
                message : "Veuillez entrer un email valide",
            }) ;
        }
    });
}

FormValidator.prototype.checkMinChecked = function()
{
    let classThis = this ;
    this.form.find("[data-minchecked]").each(function ()
    {
        let minChecked = $(this).data("minchecked") ;

        let allchecked = $(this).find("input[type=checkbox]:checked") ;

        if (allchecked.length < minChecked)
        {
            classThis.allErrors.push({
                domElement : $(this),
                message : "Veuillez cocher au moins "+minChecked+" cases.",
            }) ;
        }
    });
}


FormValidator.prototype.checkEqualFields = function()
{
    let classThis = this ;
    this.form.find("[data-equal]").each(function ()
    {
        let value = $(this).val() ;
        let otherEqualFields = $("[data-equalcopy="+$(this).data("equal")+"]") ;
        let error = false ;
        otherEqualFields.each(function()
        {
            error = error || ($(this).val() != value) ;
        }) ;

        if (error)
        {
            classThis.allErrors.push({
                domElement : $(this),
                message : "Ces champs doivent avoir la même valeur",
            }) ;
        }
    });

}

FormValidator.prototype.displayAllErrors = function()
{
    if (this.allErrors.length > 0)
    {
        this.allErrors.forEach(function (error) {
            let errorDiv = $("<div>");
            errorDiv.addClass("form-error");
            errorDiv.html(error.message);
            error.domElement.before(errorDiv);

        })
    }
}






FormValidator.prototype.onSubmit = function(event)
{
    // event.preventDefault();
    this.allErrors = [];
    $(".form-error").remove();

    this.checkRequired();
    this.checkMinLength();
    this.checkDataType();
    this.checkRequiredSelect();
    this.checkMinChecked();
    this.checkEmail();
    this.checkEqualFields();


    this.displayAllErrors();


    if (this.allErrors.length>0)
    {
        event.preventDefault();
    }

}

// FormValidator.prototype.run = function()
// {
//         this.checkRequired();
//         this.displayAllErrors();
// }




$(function () {

    let formVal = new FormValidator($("form[data-validate]"));
    formVal.form.on("submit", formVal.onSubmit.bind(formVal));

});
