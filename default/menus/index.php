<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BAAS - Vrolijk Toneel Initiatief</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"
            integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"
            integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/"
            crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/6e9f44a530.js" crossorigin="anonymous"></script>

</head>
<body>

<nav class="navbar navbar-light border shadow-sm d-sticky top-0">
    <div class="container-fluid d-flex justify-content-between">
        <button class="navbar-brand ms-4 col-2 btn btn-light bg-transparent p-0 border-0" onclick="renderHomePage()">
            <img src="tjokLogoText.png" alt="brand Text" class="d-inline-block align-text-top img-fluid h-100"
                 style="height:40px!important">
        </button>
        <button class="btn bg-transparent position-relative me-3 p-1" id="cartIcon" onclick="renderOrderOverview()">
            <i class="text-dark fas fa-shopping-cart position-relative fs-4 "></i>
        </button>
    </div>
</nav>
<a class="btn btn-light bg-transparent border shadow-sm border-end-0 float-end pt-3" data-bs-toggle="offcanvas"
   href="#offcanvasExample"
   role="button"
   aria-controls="offcanvasExample">
    <div class="d-flex flex-row flex-nowrap justify-content-between align-items-baseline">
        <i class="fas fa-chevron-left me-3"></i>
        <p class="lead fw-bold">menu</p>
    </div>
</a>

<div class="container mt-5 mx-auto row d-flex justify-content-center" id="productOverview">
    <!--product will be filled in here-->
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Categorieën</h5>
        <button type="button" class="btn-close text-reset" id="closeOffcanvas" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>

    </div>
    <div class="offcanvas-body">
        <div class="list-group" id="categoryField">
            <!--categories will be filled in here-->
        </div>
    </div>

</div>


<script>
    let order = JSON.parse(localStorage.getItem("order")) || {}
    const products = [
        {
            id: 1,
            name: "Cola",
            price: 5.0,
            categoryid: 1
        }, {
            id: 2,
            name: "Cola Zero",
            price: 5.0,
            categoryid: 1
        }, {
            id: 3,
            name: "Plat water",
            price: 4.0,
            categoryid: 1
        }, {
            id: 4,
            name: "Bruiswater",
            price: 4.0,
            categoryid: 1
        }, {
            id: 5,
            name: "Ice Tea",
            price: 5.0,
            categoryid: 1
        }, {
            id: 5,
            name: "Fanta",
            price: 5.0,
            categoryid: 1
        }, 
//        {
//            id: 6,
//            name: "Jupiler",
//            price: 5.0,
//            categoryid: 2
//        }, {
//            id: 7,
//            name: "Jupiler 0,0%",
//            price: 5.0,
//            categoryid: 2
//        }, {
//            id: 8,
//            name: "Grimbergen Double",
//            price: 9.00,
//            categoryid: 2,
        //}, 
        {
            id: 9,
            name: "Fruitsap",
            price: 5.0,
            categoryid: 1,
        },// {
            //id: 10,
            //name: "Duvel",
            //price: 9.0,
            //categoryid: 2
        //}, {
            //id: 11,
            //name: "Cava (Codorniu)",
            //price: 9.0,
            //categoryid: 2
        //}, {
          //  id: 12,
            //name: "Cava (Codorniu 0%)",
        //    price: 9.00,
          //  categoryid: 2
        //}, {
        //    id: 13,
        //    name: "Koffie",
        //    price: 4.00,
        //    categoryid: 1
        //},
        {
            id: 14,
            name: "Sandwich Hesp",
            price: 3.00,
            categoryid: 3
        }, {
            id: 15,
            name: "Sandwich Hesp met Boter",
            price: 3.00,
            categoryid: 3
        }, {
            id: 16,
            name: "Sanwich Kaas",
            price: 3.00,
            categoryid: 3
        }, {
            id: 16,
            name: "Sanwich Kaas met Boter",
            price: 3.00,
            categoryid: 3
        }, {
            id: 16,
            name: "Sanwich Kaas & Hesp",
            price: 4.00,
            categoryid: 3
        }, {
            id: 16,
            name: "Sanwich Kaas & Hesp met Boter",
            price: 4.00,
            categoryid: 3
        }, {
            id: 16,
            name: "Churros 3st.",
            price: 3.00,
            categoryid: 3
        }, {
            id: 16,
            name: "Churros 3st. met Bloemsuiker",
            price: 3.00,
            categoryid: 3
        }, {
            id: 16,
            name: "Churros 6st.",
            price: 6.00,
            categoryid: 3
        }, {
            id: 16,
            name: "Churros 6st. met Bloemsuiker",
            price: 6.00,
            categoryid: 3
        },
    ]
    const categories = [
        {
            name: "Frisdrank",
            id: 1
        }, //{
            //name: "Bieren",
            //id: 2
        //}, 
        {
            name: "Snacks",
            id: 3
        }
    ]
    const tables = [
        {id: 1, number: 1},
    	{id: 2, number: 2},
        {id: 3, number: 3},
    	{id: 4, number: 4},
        {id: 5, number: 5},
    	{id: 6, number: 6},
        {id: 7, number: 7},
    	{id: 8, number: 8},
        {id: 9, number: 9},
    	{id: 10, number: 10},
        {id: 11, number: 11},
    	{id: 12, number: 12},
        {id: 13, number: 13},
    	{id: 14, number: 14},
        {id: 15, number: 15},
    	{id: 16, number: 16},
        {id: 17, number: 17},
    	{id: 18, number: 18},
        {id: 19, number: 19},
    	{id: 20, number: 20},
        {id: 21, number: 21},
    	{id: 22, number: 22},
        {id: 23, number: 23},
    	{id: 24, number: 24},
        {id: 25, number: 25},
    	{id: 26, number: 26},
        {id: 27, number: 27},
    	{id: 28, number: 28},
        {id: 29, number: 29},
    	{id: 30, number: 30},
        {id: 31, number: 31},
    	{id: 32, number: 32}
    ]

    const processOrder = () => {
        if (order.betaling && order.tableid && Number(order.tableid) && order.products?.[0]) {

            console.log("submitting data")
            const form = document.createElement("form")
            form.method = "POST"
            form.action = "./succes.php"
            form.style.display = "none"
            form.id = "submitForm"
            let productString = ""
            order.products.forEach(obj => {
                productString += `${obj.amount}x ${obj.product.name} <br>`
            })

            const productInput = document.createElement("input")
            productInput.name = "productIds"
            productInput.type = "text"
            productInput.value = productString

            const betalingInput = document.createElement("input")
            betalingInput.type = "text"
            betalingInput.value = order.betaling
            betalingInput.name = "betaling"

            const tableInput = document.createElement("input")
            tableInput.type = "number"
            tableInput.name = "tableid"
            tableInput.value = order.tableid


            const totalInput = document.createElement("input")
            totalInput.type = "number"
            totalInput.name = "totaal"

            let total = 0
            order.products.forEach(obj => {
                total += obj.product.price * obj.amount
            })
            totalInput.value = total

            form.appendChild(productInput)
            form.appendChild(betalingInput)
            form.appendChild(tableInput)
            form.append(totalInput)

            document.getElementById("productOverview").appendChild(form)
            localStorage.setItem("completedOrder", JSON.stringify(order))
            order = {}
            localStorage.setItem("order", JSON.stringify(order))
            document.getElementById("submitForm").submit()
            return
        }
        stoppingAlert()
    }

    const stoppingAlert = async () => {
        const container = document.getElementById("productOverview")

        const removeButton = createElement("button", null, ["btn-close", "float-end"])
        const alertBanner = createElement("div", null, ["position-fixed", "bottom-0", "my-3", "w-75", "alert",
                "alert-danger", "border", "rounded-3", "p-2"], null,
            [
                removeButton,
                createElement("p", `Nog niet alle gegevens zijn ingevuld`, ["lead", "mt-3"])
            ]
        )
        removeButton.addEventListener("click", () => fadeOut(alertBanner))

        setTimeout(() => {
            fadeOut(alertBanner)
        }, 3500)

        container.appendChild(alertBanner)
        fadeIn(alertBanner)
    }
</script>

<script src="js/helperFunctions.js"></script>
<script src="js/shoppingCart.js"></script>
<script src="js/productElements.js"></script>
<script src="js/offCanvasElements.js"></script>
<script src="js/script.js"></script>

</body>
</html>