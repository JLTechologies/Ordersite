const updateCart = () => {
    const icon = document.getElementById("cartIcon")
    if (document.getElementById("orderLength")) icon.removeChild(document.getElementById("orderLength"))
    if (order.products) {
        icon.appendChild(createElement("span", order.products.length,
            ["position-absolute", "top-0", "start-100", "translate-middle", "badge",
                "rounded-pill", "bg-primary"], "orderLength"))
    }
}

const renderOrderOverview = (bypass) => {
    const container = document.getElementById("productOverview")
    if (bypass || !document.getElementById("orderOverview")) {
        container.innerHTML = ""
        const orderContainer = createElement("div", null, ["container"], "orderOverview")

        const orderList = renderProductField()
        const orderListGroup = createElement("div", null, ["list-group", "col-12"], null,
            orderList)
        if (order.products)
            orderContainer.appendChild(createElement("h1", "bestelling:", ["display-6"]))

        orderContainer.appendChild(orderListGroup)
        container.appendChild(orderContainer)
        container.appendChild(createTotal())
        container.appendChild(createPaymentMethod())
        container.appendChild(createTableOverview())
        container.appendChild(finishOrder())
    }
}

const renderProductField = () => {
    let list = []
    if (!order.products) {
        list = [createElement("h1", "nog geen bestelling geplaatst", ["display-6", "text-center", "mt-3"])]
        return list
    }
    order.products.forEach(obj => {
        const product = obj.product

        const liEl = createProductField(product, obj.amount)

        list = [...list, liEl]
    })

    return list
}

const createProductField = (product, amount) => {

    const children = [
        createElement("p", `${amount}x ${product.name}`, ["lead", "fw-normal", "me-5", "my-0"], ""),
        createElement("p", `€${amount * product.price}`, ["lead", "ms-5", "my-0"])]

    const liEl = document.createElement("li")
    liEl.classList.add("list-group-item")
    const container = createElement("div", null,
        ["d-flex", "justify-content-between", "align-items-baseline", "py-3", "flex-wrap"],
        `orderView-${product.name}`, children)
    container.onclick = () => {
        if (document.getElementById(`order-${product.name}`)) {
            liEl.removeChild(document.getElementById(`order-${product.name}`))
            return
        }
        const amountList = document.querySelectorAll('[id^=order-]')
        amountList.forEach(el => el.remove())
        liEl.appendChild(createProductSubField(product))
    }
    liEl.appendChild(container)

    return liEl
}

const createProductSubField = (product) => {
    const container = createElement("div", null, ["container", "mt-2"], `order-${product.name}`)
    container.appendChild(createAmountFieldOrder(product))
    container.appendChild(createRemoveButton(product))
    return container
}

const createRemoveButton = (product) => {
    const div = createElement("div", null, ["container", "d-flex", "justify-content-end", "mt-3", "px-2"])
    const button = createElement("button", "verwijderen", ["btn", "btn-danger"])
    button.addEventListener("click", () => removeProduct(product.id))
    div.appendChild(button)
    return div
}

const removeProduct = (productId) => {
    console.log("removing product with id " + productId)
    order.products = [...order.products.filter(obj => obj.product.id !== productId)]
    localStorage.setItem("order", JSON.stringify(order))
    renderOrderOverview(true)
}

const createAmountFieldOrder = (product) => {

    const amountContainer = document.createElement("div")
    amountContainer.classList.add("d-flex", "justify-content-end", "align-items-center", "flex-nowrap")

    const minusButton = createElement("button", null, ["btn", "btn-light", "bg-transparent", "p-1"], null,
        [createElement("i", null, ["fas", "fa-minus"])])
    minusButton.onclick = () => reduceAmountOrder(`amount-${product.name}`, product)
    amountContainer.appendChild(minusButton)

    const amountEl = createElement("input", null, ["form-control", "mx-3", "w-25", "text-center"],
        `amount-${product.name}`, null,
        [{name: "type", value: "number"}])
    amountEl.value = order?.products?.find(obj => obj.product.id === product.id)?.amount || 1
    amountContainer.appendChild(amountEl)

    const plusButton = createElement("button", null, ["btn", "btn-light", "bg-transparent", "p-1"], null,
        [createElement("i", null, ["fas", "fa-plus"])])
    plusButton.onclick = () => increaseAmountOrder(`amount-${product.name}`, product)
    amountContainer.appendChild(plusButton)

    return amountContainer
}

const reduceAmountOrder = (id, product) => {
    const el = document.getElementById(id)
    const amount = Number(el.value)
    reduceAmount(id, product.id)
    updateOverviewField(product, amount - 1)
}

const increaseAmountOrder = (id, product) => {
    const el = document.getElementById(id)
    const amount = Number(el.value)
    increaseAmount(id, product.id)
    updateOverviewField(product, amount + 1)
}

const updateOverviewField = (product, amount) => {
    const el = document.getElementById(`orderView-${product.name}`)
    el.innerHTML = ""
    const children = [
        createElement("p", `${amount}x ${product.name}`, ["lead", "fw-normal", "me-5", "my-0"], ""),
        createElement("p", `€${amount * product.price}`, ["lead", "ms-5", "my-0"])]

    children.forEach(child => el.appendChild(child))
}

const createTotal = () => {
    let totalPrice = 0
    order.products.forEach(obj => totalPrice += (obj.product.price * obj.amount))
    return createElement("div", null, ["container", "d-flex", "justify-content-between", "p-3"], null, [
        createElement("p", "totaal", ["lead"]),
        createElement("p", `€${totalPrice}`, ["lead"])
    ])
}

const createPaymentMethod = () => {
    const cashSelected = order.betaling === "Cash" || false
    console.log(cashSelected)
    const payconiqSelected = order.betaling === "Payconiq" || false
    console.log(payconiqSelected)
    const cashInput = createElement("input", null, ["form-check-input"], "paymentCash", null,
        [{name: "type", value: "radio"}, {name: "name", value: "payment"}])
    cashInput.onclick = () => setPayment("Cash")
    if (cashSelected) cashInput.checked = true
    const payconiqInput = createElement("input", null, ["form-check-input"], "paymentPayconiq", null,
        [{name: "type", value: "radio"}, {name: "name", value: "payment"}])
    payconiqInput.onclick = () => setPayment("Payconiq")
    if (payconiqSelected) payconiqInput.checked = true
    const container = createElement("div", null, ["container", "mx-auto", "d-flex", "flex-column", "mt-3"],
        null,
        [
            createElement("h1", "Betalingswijze", ["display-6"]),
            createElement("div", null, ["form-check"], null, [
                cashInput,
                createElement("label", "Cash", ["form-check-label"], null, null,
                    [{name: "for", value: "paymentCash"}])
            ]),
            createElement("div", null, ["form-check"], null, [
                payconiqInput,
                createElement("label", "Payconiq", ["form-check-label"], null, null,
                    [{name: "for", value: "paymentPayconiq"}])
            ])
        ])

    return container
}

const setPayment = (value) => {
    order.betaling = value
    localStorage.setItem("order", JSON.stringify(order))
}

const createTableOverview = () => {
    let tableEllist = [createElement("option", "selecteer je tafel", ["lead"], null, null,
        [{name: "selected", value: true}, {name: "value", value: null}])]
    tables.forEach((table) => {
        tableEllist = [...tableEllist, createElement("option", `tafel ${table.number}`, ["lead"],
            null, null, [{name:"value", value:table.id}])]
    })

    const select = createElement("select", null, ["form-select", "my-3"], null, tableEllist)
    select.addEventListener("change", (e) => {
        order.tableid = e.target.value
        localStorage.setItem("order", JSON.stringify(order))
    })

    return select
}

const finishOrder = () => {
    const button = createElement("button", "bestelling afronden", ["btn", "btn-primary"])
    button.onclick = () => processOrder()
    return createElement("div", null, ["container", "d-flex", "justify-content-end", "my-3"], null, [button])
}


updateCart()