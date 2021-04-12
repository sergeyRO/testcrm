<style>
    form {
        position: relative;
        width: 300px;
        margin: 0 auto;
    }
    .formwrapper {
        position: relative;
        width: 100%;
        margin: 0 auto;
    }
    .find {background: #F9F0DA;}

    .find form {
        background: #A3D0C3;
    }

    .find input {
        width: 100%;
        height: 42px;
    }
    .find button {
        height: 42px;
        width: 42px;
        position: absolute;
        top: 0;
        right: 0;
        cursor: pointer;
    }
    .find button:before {
        content: "\f002";
        font-family: FontAwesome;
        font-size: 16px;
        color: green;
    }



    #kabsearchform {
        display: none;
        position: absolute;
        background-color: #fafafa;
        border: solid 1px #a3a3a3;
        padding: 5px 10px;
        font-family: Arial;
        -webkit-box-shadow: inset 0 2px 3px rgba(0, 0, 0, .1);
        -moz-box-shadow: inset 0 2px 3px rgba(0, 0, 0, .1);
        box-shadow: inset 0 2px 3px rgba(0, 0, 0, .1);
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-appearance: none;
        z-index: 99;
        line-height: normal;
    }

    .mosearchresult {
        width: 100%;
        padding: 3px;
        text-align: left;
        border-bottom: #eeeeee solid 1px;
    }

    .mosearchresult a, .mosearchresulttotal a {
        font-size: 12pt;
    }

    .mosearchresulttotal {
        font-size: 12pt;
        color: #000000;
        text-decoration: none;
    }

    .mosearchresult span {
        font-size: 12pt;
        color: #999999;
    }

</style>