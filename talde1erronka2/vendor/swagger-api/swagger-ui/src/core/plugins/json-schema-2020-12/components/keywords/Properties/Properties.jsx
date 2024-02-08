/**
 * @prettier
 */
import React from "react"
import classNames from "classnames"

import { schema } from "../../../prop-types"
import { useFn, useComponent } from "../../../hooks"

const Properties = ({ schema }) => {
  const fn = useFn()
  const properties = schema?.properties || {}
  const required = Array.isArray(schema?.required) ? schema.required : []
  const JSONSchema = useComponent("JSONSchema")

  /**
   * Rendering.
   */
  if (Object.keys(properties).length === 0) {
    return null
  }

  return (
    <div className="json-schema-2020-12-keyword json-schema-2020-12-keyword--properties">
      <ul>
        {Object.entries(properties).map(([propertyName, propertySchema]) => {
          const isRequired = required.includes(propertyName)
          const dependentRequired = fn.getDependentRequired(
            propertyName,
            schema
          )

          return (
            <li
              key={propertyName}
              className={classNames("json-schema-2020-12-property", {
                "json-schema-2020-12-property--required": isRequired,
              })}
            >
              <JSONSchema
                name={propertyName}
                schema={propertySchema}
                dependentRequired={dependentRequired}
              />
            </li>
          )
        })}
      </ul>
    </div>
  )
}

Properties.propTypes = {
  schema: schema.isRequired,
}

export default Properties
