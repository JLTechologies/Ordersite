const renderProductOverview = (id) => {
    const parent = document.getElementById("productOverview")

    parent.innerHTML = ""
    parent.appendChild(createLoadingIcon())

    createProductList(id).then((data) => {
        parent.innerHTML = ""
        parent.appendChild(data)
    })
}

const createLoadingIcon = () => {
    const attributes = [{name: "role", value: "status"}]

    return createElement("div", null, ["spinner-border", "text-primary", "text-center"],
        null,
        [createElement("span", "Loading...", ["visually-hidden"])]
        , [...attributes])
}

const createProductList = async (id) => {
    const categoryProducts = products.filter(product => product.categoryid === id)

    const productContainer = createElement("div", null, ["list-group", "col-12"], null,
        [createElement("h1", categories.find(category => category.id === id).name,
            ["display-6", "text-center", "fw-normal", "mb-3"])])

    categoryProducts.forEach(product => {
        productContainer.appendChild(createProductEl(product))
    })
    return productContainer
}

const createProductEl = (product) => {

    const children = [
        createElement("div", null, ["d-flex", "justify-content-between", "align-items-baseline", "flex-nowrap"], null, [
            createElement("p", product.name, ["lead", "fw-normal", "me-5", "my-0"]),
            createElement("div", null, ["d-flex", "justify-content-end", "flex-nowrap", "align-items-baseline"], null, [
                createElement("p", `${Number(product.price).toFixed(2)} Bon(nen)`, ["lead", "ms-5", "my-0", "fs-6"]),
                createElement("i", null, ["fas", 'fa-chevron-down', "ms-2", "rotate", "rotate-0"], `chevron-${product.name}`)
            ])
        ])
    ]
    if (product.description)
        children.push(createElement("p", product.description, ["w-100", "m-0", "mt-1", "lead", "text-muted", "fs-6"]))

    const liEl = document.createElement("li")
    liEl.classList.add("list-group-item")
    const container = createElement("div", null,
        ["py-3", "flex-nowrap"],
        null,
        children)
    container.onclick = () => {
        createProductSubEl(product, liEl)
    }

    liEl.appendChild(container)
    return liEl
}

const createProductSubEl = async (product, el) => {
    document.querySelectorAll('[id^=chevron-]').forEach(el => el.classList.replace("rotate-180", "rotate-0"))

    if (document.getElementById(`amount-${product.name}`)) {
        fadeOut(document.getElementById(`productamount-${product.name}`), true)
        return
    }
    document.querySelectorAll('[id^=productamount-]').forEach(el => fadeOut(el, true))

    document.getElementById(`chevron-${product.name}`).classList.replace("rotate-0", "rotate-180")

    const container = createElement("div", null,
        ["container", "px-2", "my-2"],
        `productamount-${product.name}`, [
            createAmountField(product),
            createAddToOrderButton(product)
        ])
    el.appendChild(container)
    fadeIn(container, true)
}


const createAmountField = (product) => {

    const amountContainer = document.createElement("div")
    amountContainer.classList.add("d-flex", "justify-content-end", "align-items-center", "flex-nowrap")

    const minusButton = createElement("button", null, ["btn", "btn-light", "bg-transparent", "p-1"], null,
        [createElement("i", null, ["fas", "fa-minus"])])
    minusButton.onclick = () => reduceAmount(`amount-${product.name}`, product.id)
    amountContainer.appendChild(minusButton)

    const amountEl = createElement("input", null, ["form-control", "mx-3", "w-25", "text-center"],
        `amount-${product.name}`, null,
        [{name: "type", value: "number"}])
    amountEl.value = 1
    amountContainer.appendChild(amountEl)

    const plusButton = createElement("button", null, ["btn", "btn-light", "bg-transparent", "p-1"], null,
        [createElement("i", null, ["fas", "fa-plus"])])
    plusButton.onclick = () => increaseAmount(`amount-${product.name}`, product.id)
    amountContainer.appendChild(plusButton)

    return amountContainer
}

const reduceAmount = (id, productId, updateStorage) => {
    const el = document.getElementById(id)
    const amount = Number(el.value)
    if (amount > 1) {
        el.value = `${amount - 1}`
        if (order?.products?.find(obj => obj.product.id === productId) && updateStorage) {
            const orderProduct = order.products.find(obj => obj.product.id === productId)
            orderProduct.amount = amount - 1
            order.products = [...order.products.filter(obj => obj.product.id !== productId), orderProduct]
            localStorage.setItem("order", JSON.stringify(order))
        }
    }
}

const increaseAmount = (id, productId, updateStorage) => {
    const el = document.getElementById(id)
    const amount = Number(el.value)
    amount < 1 ? el.value = 1 : el.value = `${amount + 1}`
    if (order?.products?.find(obj => obj.product.id === productId) && updateStorage) {
        const orderProduct = order.products.find(obj => obj.product.id === productId)
        amount < 1 ? order.amount = 1 : orderProduct.amount = amount + 1
        order.products = [...order.products.filter(obj => obj.product.id !== productId), orderProduct]
        localStorage.setItem("order", JSON.stringify(order))
    }
}

const createAddToOrderButton = (product) => {
    const button = createElement("button", "toevoegen",
        ["btn", "btn-primary", "m-2", "mt-3"])
    button.addEventListener("click", () => addProductToOrder(product))
    const div = createElement("div", null, ["d-flex", "justify-content-end", "w-100"],
        null, [button])
    return div
}

const addProductToOrder = (product) => {
    const amount = Number(document.getElementById(`amount-${product.name}`).value)

    let products = order.products?.filter(obj => obj.product.id !== product.id) || []

    productAddedBanner(product, amount).then(() => {
            const productAmount = order?.products?.find(obj => Number(obj.product.id) === Number(product.id))?.amount + amount || amount
            order.products = [...products, {product: {...product}, amount: productAmount}]
            localStorage.setItem("order", JSON.stringify(order))
            updateCart()
        }
    )
}

const productAddedBanner = async (product, amount) => {
    const container = document.getElementById("productOverview")


    const removeButton = createElement("button", null, ["btn-close", "float-end"])
    const productBanner = createElement("div", null, ["position-fixed", "bottom-0", "my-3", "w-75", "alert",
            "alert-success", "border", "rounded-3", "p-2"], null,
        [
            removeButton,
            createElement("p", `${amount}x ${product.name} toegevoegd aan je winkelmand`, ["lead", "mt-3"])
        ]
    )
    removeButton.addEventListener("click", () => fadeOut(productBanner))

    setTimeout(() => {
        fadeOut(productBanner)
    }, 3500)

    container.appendChild(productBanner)
    fadeIn(productBanner)
    fadeOut(document.getElementById(`productamount-${product.name}`), true)
}