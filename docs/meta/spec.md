# Fluidity — Package Specification

> **Cluster:** `language`
> **Language:** `php`
> **Milestone:** `m2`
> **Repo:** `https://github.com/decodelabs/fluidity`
> **Role:** Fluid interfaces

This document describes the purpose, contracts, and design of **Fluidity** within the Decode Labs ecosystem.

It is aimed at:

- Developers **using** Fluidity to create fluent interfaces in their libraries.
- Contributors **maintaining or extending** Fluidity.
- Tools and AI assistants that need to reason about its behaviour.

---

## 1. Overview

### 1.1 Purpose

Fluidity provides a set of middleware interfaces and traits that aid in the development of libraries that themselves aim to provide fluid (fluent) interfaces. It offers three core patterns: method chaining with conditional callbacks (`Then`), type-safe casting (`Cast`), and single-parameter factory methods (`SingleParameterFactory`). These patterns enable developers to create expressive, chainable APIs with minimal boilerplate code, improving code readability and developer experience.

### 1.2 Non-Goals

Fluidity does **not**:

- Provide a complete fluent interface framework or DSL
- Implement specific business logic or domain models
- Provide validation or data transformation beyond type casting
- Implement method chaining for specific use cases (e.g., query builders, configuration builders)
- Provide dependency injection or service container functionality
- Implement event handling or observer patterns
- Provide caching or memoization for fluent operations
- Implement lazy evaluation or deferred execution
- Provide serialization or persistence for fluent objects
- Implement complex control flow beyond simple conditionals

Fluidity focuses on providing reusable, composable building blocks for fluent interfaces, not on implementing complete fluent API solutions.

---

## 2. Role in the Ecosystem

### 2.1 Cluster & Positioning

- **Cluster:** `language` (see Chorus taxonomy)
- Fluidity is positioned as a language-level utility that provides foundational patterns for creating fluent interfaces. It sits at a low level in the ecosystem, used by many other packages (Collections, Dictum, Systemic, Compass, Harvest, Dovetail, Elementary, etc.) to provide fluent APIs. It is a pure PHP library with no dependencies, making it suitable for use in any PHP project.

### 2.2 Typical Usage Contexts

Typical places Fluidity appears:

- Libraries providing fluent method chaining APIs
- Value objects that need type-safe casting
- Factory classes that accept single parameters
- Configuration builders and query builders
- Text manipulation libraries (e.g., Dictum)
- Collection libraries (e.g., Collections)
- System operation libraries (e.g., Systemic)
- HTTP libraries (e.g., Harvest)
- Configuration libraries (e.g., Dovetail)
- Markup libraries (e.g., Elementary)
- Any library that wants to provide a fluent, chainable interface

Fluidity is intended to be used as a foundation for building fluent interfaces, providing common patterns that can be composed into more complex APIs.

---

## 3. Public Surface

> This section focuses on the conceptual API, not every symbol.

### 3.1 Key Types

The primary public types are:

- `DecodeLabs\Fluidity\Then`
  Interface for method chaining with conditional callbacks. Provides `then()`, `thenEach()`, `thenIf()`, and `thenUnless()` methods for executing callbacks in various contexts. Used to create fluent interfaces that support conditional logic and iteration.

- `DecodeLabs\Fluidity\ThenTrait`
  Trait implementation of the `Then` interface. Provides default implementations for all `Then` methods. Classes implement `Then` and use this trait to add fluent method chaining capabilities.

- `DecodeLabs\Fluidity\Cast`
  Interface for type-safe casting. Provides `as()` method for casting objects to specific types with runtime type checking. Used to provide type-safe access to object capabilities.

- `DecodeLabs\Fluidity\CastTrait`
  Trait implementation of the `Cast` interface. Provides default implementation that checks if the object is an instance of the requested type and throws `TypeError` if not. Classes implement `Cast` and use this trait to add type-safe casting capabilities.

- `DecodeLabs\Fluidity\SingleParameterFactory`
  Interface for factory pattern with single parameter. Provides `instance()` and `orNull()` static methods for creating instances from a single input value. Used to create factory methods that accept either the input type or an existing instance.

- `DecodeLabs\Fluidity\SingleParameterFactoryTrait`
  Trait implementation of the `SingleParameterFactory` interface. Provides default implementations that handle both input values and existing instances, with null-safe `orNull()` method. Classes implement `SingleParameterFactory` and use this trait to add factory capabilities.

### 3.2 Main Entry Points

The main usage pattern is through implementing interfaces and using traits:

```php
use DecodeLabs\Fluidity\Then;
use DecodeLabs\Fluidity\ThenTrait;

class MyClass implements Then
{
    use ThenTrait;
    
    // Your class methods
}
```

For type-safe casting:

```php
use DecodeLabs\Fluidity\Cast;
use DecodeLabs\Fluidity\CastTrait;

class MyClass implements Cast
{
    use CastTrait;
    
    // Your class methods
}
```

For factory methods:

```php
use DecodeLabs\Fluidity\SingleParameterFactory;
use DecodeLabs\Fluidity\SingleParameterFactoryTrait;

class MyValue implements SingleParameterFactory
{
    use SingleParameterFactoryTrait;
    
    public function __construct(protected string $value) {}
}
```

---

## 4. Dependencies

### 4.1 Decode Labs

- No Decode Labs dependencies. Fluidity is a pure PHP library with no external dependencies.

### 4.2 External

- No external dependencies beyond PHP core.

### 4.3 Optional Integrations

- No optional integrations. Fluidity is designed to be dependency-free.

---

## 5. Behaviour & Contracts

### 5.1 Invariants

- `Then` methods always return `$this` (the implementing object)
- `Then` callbacks receive the implementing object as the first parameter
- `thenEach()` callbacks receive `($this, $value, $key)` parameters
- `thenIf()` and `thenUnless()` callbacks receive `($this, $truth)` parameters
- `thenIf()` executes `$yes` callback only if `$truth === true`
- `thenUnless()` executes `$no` callback only if `$truth !== true`
- `Cast::as()` throws `TypeError` if object is not an instance of the requested type
- `Cast::as()` returns `$this` if object is an instance of the requested type
- `SingleParameterFactory::instance()` returns existing instance if input is already an instance
- `SingleParameterFactory::instance()` creates new instance if input is not an instance
- `SingleParameterFactory::orNull()` returns `null` if input is `null`
- `SingleParameterFactory::orNull()` returns `null` if instance creation fails (catches exceptions)
- All methods preserve object identity (return `$this` where applicable)
- Traits require implementing classes to implement the corresponding interface

### 5.2 Input & Output Contracts

**Then Interface:**
- `then(callable $callback): Then` — Executes callback with `$this` as parameter. Returns `$this`.
- `thenEach(iterable $values, callable $callback): Then` — Iterates over values, executing callback with `($this, $value, $key)` for each item. Returns `$this`.
- `thenIf(?bool $truth, callable $yes, ?callable $no = null): Then` — Executes `$yes` if `$truth === true`, otherwise executes `$no` if provided. Both callbacks receive `($this, $truth)`. Returns `$this`.
- `thenUnless(?bool $truth, callable $no, ?callable $yes = null): Then` — Executes `$no` if `$truth !== true`, otherwise executes `$yes` if provided. Both callbacks receive `($this, $truth)`. Returns `$this`.

**Cast Interface:**
- `as(string $type): static` — Casts object to specified type. Throws `TypeError` if object is not an instance of `$type`. Returns `$this` with type narrowed to `$type`.

**SingleParameterFactory Interface:**
- `instance(mixed $value): static` — Creates instance from input value. If `$value` is already an instance of the class, returns it. Otherwise, creates new instance via constructor. Returns instance.
- `orNull(mixed $value): ?static` — Creates instance from input value, returning `null` if input is `null` or if creation fails. Returns instance or `null`.

---

## 6. Error Handling

- `Cast::as()` throws `TypeError` if object cannot be cast to requested type
- `SingleParameterFactory::instance()` may throw exceptions from constructor if input is invalid
- `SingleParameterFactory::orNull()` catches all exceptions and returns `null` instead
- `Then` methods do not throw exceptions (callbacks may throw, but methods themselves do not)
- Invalid callbacks passed to `Then` methods will cause PHP errors when called
- Invalid iterables passed to `thenEach()` will cause PHP errors during iteration
- Type errors in `Cast::as()` provide clear error messages indicating the actual and requested types

---

## 7. Configuration & Extensibility

- No configuration required. Fluidity is a pure library with no configuration options.
- Interfaces can be extended by applications for custom behavior
- Traits can be overridden by implementing classes for custom implementations
- `Then` callbacks can be any callable (functions, methods, closures, invokable objects)
- `SingleParameterFactory` can be customized by overriding `instance()` or `orNull()` methods
- `Cast` can be customized by overriding `as()` method for custom type checking logic
- Applications can compose multiple interfaces/traits for complex fluent APIs
- No extension points or plugin system (by design, for simplicity)

---

## 8. Interactions with Other Packages

### 8.1 Collections

Collections uses Fluidity's `Then` interface on collection classes, enabling fluent method chaining for collection operations.

### 8.2 Dictum

Dictum uses Fluidity's `Then` interface on the `Text` class, enabling fluent method chaining for text operations.

### 8.3 Systemic

Systemic uses Fluidity's `Then` interface for fluent system operation APIs.

### 8.4 Compass

Compass uses Fluidity's `Then` interface for fluent IP address manipulation APIs.

### 8.5 Harvest

Harvest uses Fluidity's `Then` interface for fluent HTTP request/response building APIs.

### 8.6 Dovetail

Dovetail uses Fluidity's `Cast` interface on configuration classes, enabling type-safe access to configuration capabilities.

### 8.7 Elementary

Elementary uses Fluidity's `Cast` interface on markup classes, enabling type-safe access to markup capabilities.

### 8.8 Other Packages

Many other Decode Labs packages use Fluidity patterns:
- `Singularity` — URI manipulation
- `Guidance` — UUID generation
- Various other packages for fluent APIs

---

## 9. Usage Examples

### 9.1 Basic Then Interface

```php
use DecodeLabs\Fluidity\Then;
use DecodeLabs\Fluidity\ThenTrait;

class Builder implements Then
{
    use ThenTrait;
    
    public function doThing(int $value = null): void
    {
        // Implementation
    }
}

$builder = new Builder();
$truth = true;

$builder
    ->then(function($builder) {
        $builder->doThing();
    })
    ->thenEach([1, 2, 3], function($builder, $value) {
        // Called three times
        $builder->doThing($value);
    })
    ->thenIf($truth, function($builder) {
        // This gets called if($truth)
    }, function($builder) {
        // This gets called otherwise
    })
    ->thenUnless($truth, function($builder) {
        // This gets called if(!$truth)
    }, function($builder) {
        // This gets called otherwise
    });
```

### 9.2 Cast Interface

```php
use DecodeLabs\Fluidity\Cast;
use DecodeLabs\Fluidity\CastTrait;

class Config implements Cast
{
    use CastTrait;
    
    public function getValue(): string
    {
        return 'value';
    }
}

class ExtendedConfig extends Config
{
    public function getExtendedValue(): string
    {
        return 'extended';
    }
}

$config = new ExtendedConfig();

// Type-safe access
$extended = $config->as(ExtendedConfig::class);
$extended->getExtendedValue(); // OK

// Type error if cast fails
try {
    $config->as(SomeOtherClass::class); // Throws TypeError
} catch (TypeError $e) {
    // Handle error
}
```

### 9.3 SingleParameterFactory Interface

```php
use DecodeLabs\Fluidity\SingleParameterFactory;
use DecodeLabs\Fluidity\SingleParameterFactoryTrait;

class IpAddress implements SingleParameterFactory
{
    use SingleParameterFactoryTrait;
    
    public function __construct(protected string $address) {}
    
    public function getAddress(): string
    {
        return $this->address;
    }
}

// Create from string
$ip1 = IpAddress::instance('192.168.1.1');

// Return existing instance if already an IpAddress
$ip2 = IpAddress::instance($ip1); // Returns $ip1, doesn't create new

// Null-safe creation
$ip3 = IpAddress::orNull('192.168.1.1'); // Returns IpAddress
$ip4 = IpAddress::orNull(null); // Returns null
$ip5 = IpAddress::orNull('invalid'); // Returns null if constructor throws
```

### 9.4 Composing Multiple Interfaces

```php
use DecodeLabs\Fluidity\Then;
use DecodeLabs\Fluidity\ThenTrait;
use DecodeLabs\Fluidity\Cast;
use DecodeLabs\Fluidity\CastTrait;

class FluentConfig implements Then, Cast
{
    use ThenTrait;
    use CastTrait;
    
    public function setValue(string $value): static
    {
        // Implementation
        return $this;
    }
}

$config = new FluentConfig();

$config
    ->setValue('test')
    ->then(function($config) {
        // Additional operations
    })
    ->as(FluentConfig::class)
    ->setValue('another');
```

### 9.5 Custom Then Implementation

```php
use DecodeLabs\Fluidity\Then;

class CustomBuilder implements Then
{
    public function then(callable $callback): Then
    {
        // Custom implementation with logging
        error_log('Executing then callback');
        $callback($this);
        return $this;
    }
    
    public function thenEach(iterable $values, callable $callback): Then
    {
        // Custom implementation
        foreach ($values as $key => $value) {
            $callback($this, $value, $key);
        }
        return $this;
    }
    
    public function thenIf(?bool $truth, callable $yes, ?callable $no = null): Then
    {
        // Custom implementation
        if ($truth === true) {
            $yes($this, $truth);
        } elseif ($no !== null) {
            $no($this, $truth);
        }
        return $this;
    }
    
    public function thenUnless(?bool $truth, callable $no, ?callable $yes = null): Then
    {
        // Custom implementation
        if ($truth !== true) {
            $no($this, $truth);
        } elseif ($yes !== null) {
            $yes($this, $truth);
        }
        return $this;
    }
}
```

### 9.6 Factory with Validation

```php
use DecodeLabs\Fluidity\SingleParameterFactory;
use DecodeLabs\Fluidity\SingleParameterFactoryTrait;
use DecodeLabs\Exceptional;

class Email implements SingleParameterFactory
{
    use SingleParameterFactoryTrait;
    
    public function __construct(protected string $address)
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw Exceptional::InvalidArgument(
                message: 'Invalid email address: ' . $address
            );
        }
    }
    
    public function getAddress(): string
    {
        return $this->address;
    }
}

// Valid email
$email1 = Email::instance('test@example.com'); // OK

// Invalid email
try {
    $email2 = Email::instance('invalid'); // Throws exception
} catch (Exception $e) {
    // Handle error
}

// Null-safe with invalid input
$email3 = Email::orNull('invalid'); // Returns null instead of throwing
```

---

## 10. Implementation Notes (for Contributors)

### 10.1 Internal Architecture

At a high level, Fluidity:
- Provides three independent interfaces/traits for different fluent patterns
- Uses traits to provide default implementations that can be overridden
- Maintains object identity (returns `$this`) for fluent chaining
- Uses PHP's type system for type safety in `Cast`
- Uses static methods for factory pattern in `SingleParameterFactory`
- Catches exceptions in `orNull()` for null-safe factory methods
- Provides clear error messages for type mismatches

### 10.2 Then Pattern

The `Then` pattern enables:
- Method chaining with callbacks
- Conditional execution based on boolean values
- Iteration over collections with callbacks
- Composable fluent APIs

Implementation details:
- Callbacks receive the implementing object as first parameter
- `thenEach()` provides both value and key to callbacks
- `thenIf()` and `thenUnless()` provide the truth value to callbacks
- All methods return `$this` for chaining

### 10.3 Cast Pattern

The `Cast` pattern enables:
- Type-safe access to object capabilities
- Runtime type checking with clear error messages
- Type narrowing for static analysis tools

Implementation details:
- Uses `instanceof` for type checking
- Throws `TypeError` for invalid casts
- Returns `$this` with type narrowed for static analysis
- Works with inheritance hierarchies

### 10.4 SingleParameterFactory Pattern

The `SingleParameterFactory` pattern enables:
- Factory methods that accept input values or existing instances
- Null-safe factory methods
- Consistent instance creation patterns

Implementation details:
- `instance()` checks if input is already an instance
- `orNull()` handles null inputs and exceptions gracefully
- Constructor is called with input value for new instances
- Works with any single-parameter constructor

### 10.5 Design Decisions

- **No dependencies**: Fluidity is designed to be dependency-free for maximum compatibility
- **Trait-based**: Uses traits for default implementations, allowing easy composition
- **Interface-based**: All patterns are defined as interfaces for maximum flexibility
- **Type-safe**: Uses PHP's type system where possible (e.g., `Cast::as()`)
- **Exception handling**: `orNull()` catches all exceptions for null-safe behavior
- **Object identity**: All methods return `$this` to preserve object identity
- **Callback parameters**: Callbacks receive the implementing object for context

### 10.6 Performance Considerations

- Trait methods are simple and have minimal overhead
- `instanceof` checks in `Cast::as()` are fast
- `thenEach()` iterates efficiently over any iterable
- No caching or memoization (by design, for simplicity)
- Static methods in factories have no instance overhead

### 10.7 Gotchas & Historical Decisions

- `Then` callbacks must accept the implementing object as first parameter
- `thenIf()` and `thenUnless()` only execute callbacks based on strict boolean comparison (`=== true` or `!== true`)
- `Cast::as()` throws `TypeError`, not a custom exception type
- `SingleParameterFactory::orNull()` catches all exceptions, which may hide important errors
- Factory pattern assumes single-parameter constructor
- Traits require implementing classes to implement the corresponding interface (PHPStan enforces this)
- `thenEach()` provides both value and key to callbacks, which may be unexpected
- `thenIf()` and `thenUnless()` provide the truth value to callbacks, not just the object
- No validation or transformation in factory methods (by design, for simplicity)

---

## 11. Testing & Quality

- **Code Quality Score:** 3/5
- **README Quality Score:** 3/5
- **Documentation Score:** 0/5 (this spec)
- **Test Coverage Score:** 0/5

See `composer.json` for supported PHP versions.

---

## 12. Roadmap & Future Ideas

- Enhanced documentation and examples
- Additional fluent patterns (e.g., `Map`, `Filter`, `Reduce`)
- Enhanced type safety for factory patterns
- Better static analysis support
- Performance optimizations
- Additional conditional patterns
- Enhanced error messages
- Better integration with PHP 8+ features
- Additional factory patterns (e.g., multi-parameter factories)
- Enhanced callback patterns
- Better null safety patterns
- Additional type casting patterns
- Enhanced composition patterns

---

## 13. References

- [Collections Package](https://github.com/decodelabs/collections) — Uses `Then` for fluent collection operations
- [Dictum Package](https://github.com/decodelabs/dictum) — Uses `Then` for fluent text operations
- [Systemic Package](https://github.com/decodelabs/systemic) — Uses `Then` for fluent system operations
- [Compass Package](https://github.com/decodelabs/compass) — Uses `Then` for fluent IP operations
- [Harvest Package](https://github.com/decodelabs/harvest) — Uses `Then` for fluent HTTP operations
- [Dovetail Package](https://github.com/decodelabs/dovetail) — Uses `Cast` for type-safe configuration access
- [Elementary Package](https://github.com/decodelabs/elementary) — Uses `Cast` for type-safe markup access
- [Chorus Package Index](../../../chorus/config/packages.json) — Ecosystem metadata

