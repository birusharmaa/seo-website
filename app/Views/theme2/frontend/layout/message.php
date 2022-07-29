<form class="contact-form">
    <div class="row">
        <div class="form-group col-md-6">
            <input type="text" id="userName"
                name="name" class="form-control" placeholder="Your Name" 
            />
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" id="userPhone"
                name="number" maxlength="10" placeholder="mobile number" 
            />
        </div>
    </div>
    <div class="form-group mt-30">
        <input type="text" class="form-control" id="userEmail"
            name="email" placeholder="Your Email" 
        />
    </div>
    <div class="form-group mt-30">
        <textarea class="form-control" name="message" id="userMessage" rows="3" placeholder="Message" ></textarea>
    </div>

    <div class="text-center mt-30">
        <button type="button" id="sendMessage" class="btn btn-primary rounded-pill ">
            Send Message
        </button>
    </div>
</form>