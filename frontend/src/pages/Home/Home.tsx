import React, { useState } from "react"
import { Link } from "react-router-dom"
import './styles.scss'
import useProductList from "../../hooks/useProductList"
import { useDelete } from "hooks/useDelete"
import { Product } from "hooks/types"

const Home = () => {

  const [selected, setSelected] = useState<string[]>([]);

  const products = useProductList();


  const deleteProducts = useDelete();

  const onSelect = (sku: string) => {
    const prev = [...selected]
    const index = selected.indexOf(sku)

    if (index === -1) {
      setSelected([...prev, sku])
    } else {
      const p = prev.slice(index, 1)
      setSelected([...p])
    }
  }

  const onMassDelete = async () => {

    if (!selected.length) return;


    const error = await deleteProducts(selected);

    if (!error) {
      products.map(p => {
        selected.includes(p.sku) &&
          products.splice(products.indexOf(p), 1)
      })
      setSelected([]);
    }

  }

  return (
    <div className="home">
      <div className="header">
        <h1>Product List</h1>
        <div>
          <Link to='addproduct'>
            <button>ADD</button>
          </Link>
          <button
            id='#delete-product-btn'
            className="delete_button"
            onClick={onMassDelete}
          >
            MASS DELETE
          </button>
        </div>
      </div>

      <div className="list_container">
        {products.map(product => {
          const { sku, name, price, weight, size, width, height, length } = product
          const priceStr = price? price.toFixed(2) : "N/A"
          return (
            <div
              key={sku}
              className="card"
            >
              <input
                type='checkbox'
                name='stuff'
                className="delete-checkbox"
                onChange={() => onSelect(sku)}
                checked={selected.includes(sku)}
              />
              <p>{sku}</p>
              <p>{name}</p>
              <p>{priceStr} $</p>
              {size && <p>{size.toFixed(2)} MB</p>}
              {weight && <p>{weight.toFixed(2)} KG</p>}
              {width && <p>Dimension: {`
                ${height}x${width}x${length}`
              }</p>}
            </div>
          )
        })}
      </div>
      <h5 className="footer">Scandiweb Test assignment</h5>
    </div>
  )
}

export default Home