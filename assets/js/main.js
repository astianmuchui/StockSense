
        var trigger,closer,modal,close;

        trigger = document.getElementById("trigger");
        closer = document.getElementById("closer");
        close_btn = document.getElementById("close");
        modal= document.getElementById("modal");


        //  Create and edit modal
        trigger.onclick =()=>{
            modal.style.display = "flex";
        }

        closer.onclick =()=>{
            // Close modal
            modal.style.display = "none";
        }

        var triggerz,closerz,modalz,closez;
        triggerz = document.getElementById("triggerz");
        closerz = document.getElementById("closez");
        close_btnz = document.getElementById("close");
        modalz = document.getElementById("modalz");

        triggerz.onclick =()=>{
            modalz.style.display = "flex";
        }

        closerz.onclick =()=>{
            modalz.style.display = "none";
        }

        var btn = document.getElementById('btn-delete')
        btn.onclick = ()=>{

            var id = btn.name
            var url = '../core/Ajax.php?id='+id+'&r=delete_user'
            let xhr = new XMLHttpRequest()
            xhr.open('DELETE',url,true)
            xhr.onload = ()=>{ 
            window.location.replace('../signup/')

            }
        xhr.send() // Sends Request
        }

        // Function to Load Cart



        function loadCart()
        {
            let cart_container = document.getElementById('cartcontainer');
            let xhr = new XMLHttpRequest()
            xhr.open('GET','../core/api/cart.php?action=my_cart',true)
            xhr.onload = ()=>{
                if(this.status==200){
                    console.log(this.responseText)
                    cart_container.innerHTML = this.responseText

                }
            }
        xhr.send() // Sends Request to file
        }

        function loadOrders()
        {
            let cart_container = document.getElementById('cartcontainer');
            let xhr = new XMLHttpRequest()
            xhr.open('GET','../core/api/cart.php?action=my_orders',true)
            xhr.onload = ()=>{
                if(this.status==200){
                    console.log(this.responseText)
                    cart_container.innerHTML = this.responseText;
                }
            }
        xhr.send() // Sends Request to file
        }

        window.onload = ()=>{
            loadCart()
        }
