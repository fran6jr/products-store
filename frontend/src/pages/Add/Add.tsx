import
React,
{
  useState,
  useEffect
} from "react"
import './styles.scss'
import {
  Product,
  ProductType
} from "hooks/types";
import {formFields as p, selectFields } from "utils/formFields";
import { Link } from "react-router-dom";
import useAddProduct from "hooks/useAddProduct";
import { useNavigate } from "react-router";

const attributes: Record<string, string> = {
  dvd: "Please, provide size",
  furniture: "Please, provide dimensions in HxWxL format",
  book: "Please, provide weight",
}


const Add = () => {

  const [product, setProduct] = useState<Product>(
    {
      sku: '',
      name: '',
    })
  const navigate = useNavigate();

  const [showError, setShowError] = useState<boolean>(false);

  

  const [productType, setProductType] = useState<ProductType>();

  const { error, loading, addProduct } = useAddProduct();

  useEffect(() => {
    setProduct({
      sku: product.sku,
      name: product.name,
      price: product.price
    });
  }, [productType]);


  const handleProductType = (event: any) => {
    const { value } = event.target;
    setProductType(value)
    setShowError(false);
  }

useEffect(() => {
    if (loading === false && !error.state) {
      navigate('/');
    }
}, [loading]);

  const handleSubmit = async (event: any) => {
    event.preventDefault();

    const checkFields = p.filter(p => !p.type || p.type === productType).map(p => p.name);

    if (checkFields.some(key => validate(key))) {
      setShowError(true);
      return;
    }

    addProduct(product);

  }

  const handleChange = (event: any) => {
    const { name, value, type } = event.target;

    setShowError(false);

    setProduct(product => ({
      ...product,
      [name]: type === "number" ? parseFloat(value) : value.trim()
    }))
  }


  const validate = (field: string): string | undefined => {
    const value: string = product[field];

    if (!value)
      return "Please, submit required data";

    const inputType = p.find(s => s.name === field)?.inputType;

    if ((inputType === "text") && (/[^0-9a-zA-Z]/.test(value)))
      return "Please, provide the data of indicated type";

  }

  const requiredFields = p.filter(p => !p.type)
  const optionalFields = p.filter(p => p.type === productType)

  const attribute = attributes[productType || ""];

  return (
    <div className="addproduct">
      <div className="header">
        <h1>Product Add</h1>
        <div>
          <button
            type="submit"
            form="product_form"
          >
            Save
          </button>

          <Link to='/'>
            <button
              id='#cancel-btn'
              className="cancel_button"
            >
              Cancel
            </button>
          </Link>
        </div>
      </div>
      <div className="form_container">
        <form id="product_form"
          onSubmit={handleSubmit}>
          {error.state && <p className="error">{error.message}</p>}
          {requiredFields?.map(field => {
            const error = validate(field.name);
            return (
              <label key={field.inputId}>
                {field.label}
                <div>
                  <input
                    id={field.inputId}
                    name={field.name}
                    type={field.inputType}
                    step={field.step}
                    value={product[field.name]}
                    onChange={handleChange}
                  //required
                  />
                  {showError && error
                    && <p className="error">{error}</p>}
                </div>
              </label>
            )
          })}

          <label className="select_label">
            Type switcher
            <select
              name="productType"
              id="productType"
              value={productType}
              onChange={handleProductType}
              required
            >
              {selectFields.map(selectField => (
                <option key={selectField.inputId}
                  value={selectField.value}
                >
                  {selectField.text}
                </option>
              ))}
            </select>
          </label>
          {productType && optionalFields &&
            <div
              className="product_form" >
              {optionalFields?.map(field => {
                const error = validate(field.name);
                return (
                  <label key={field.inputId}>
                    {field.label}
                    <div>
                      <input
                        id={field.inputId}
                        name={field.name}
                        type={field.inputType}
                        step={field.step}
                        value={product[field.name]}
                        onChange={handleChange}
                      //required
                      />
                      {showError && error
                        && <p className="error">{error}</p>}
                    </div>
                  </label>
                )
              })}
              {attribute &&
                <p>{attribute}</p>}
            </div>
          }
          {/* {globalError &&
            <p className="error">{globalError}</p>
          } */}
        </form>
      </div>
      <h5 className="footer">Scandiweb Test assignment</h5>
    </div >
  )
}

export default Add