/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

//import MyUploadAdapter from "./assets/ckeditor/MyUploadAdapter.js";

var MyUploadAdapter = require("./assets/ckeditor/MyUploadAdapter.js");
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";


function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get("FileRepository").createUploadAdapter = loader => {
        // Configure the URL to the upload script in your back-end here!
        return new MyUploadAdapter(loader);
    };
}

if (document.querySelector("#content")) {
    ClassicEditor.create(document.querySelector("#content"), {
        extraPlugins: [MyCustomUploadAdapterPlugin]
    })
        .then(editor => { })
        .catch(error => {
            console.error(error.stack);
        });
}
