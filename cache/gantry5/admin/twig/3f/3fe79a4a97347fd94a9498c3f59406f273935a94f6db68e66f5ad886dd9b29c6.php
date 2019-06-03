<?php

/* forms/fields/input/url.html.twig */
class __TwigTemplate_55bf1ff4ebadef1f1ba73c2d2182419c98555725f427ae109756678955c53a28 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("forms/fields/input/group/group.html.twig", "forms/fields/input/url.html.twig", 1);
        $this->blocks = array(
            'input' => array($this, 'block_input'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "forms/fields/input/group/group.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_input($context, array $blocks = array())
    {
        // line 4
        echo "    <input
            ";
        // line 6
        echo "            type=\"url\"
            name=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->fieldNameFilter((($context["scope"] ?? null) . ($context["name"] ?? null))), "html", null, true);
        echo "\"
            value=\"";
        // line 8
        echo twig_escape_filter($this->env, twig_join_filter(($context["value"] ?? null), ", "), "html", null, true);
        echo "\"
            ";
        // line 10
        echo "            ";
        $this->displayBlock("global_attributes", $context, $blocks);
        echo "
            ";
        // line 12
        echo "            ";
        if (twig_in_filter($this->getAttribute(($context["field"] ?? null), "autocomplete", array()), array(0 => "on", 1 => "off"))) {
            echo "autocomplete=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["field"] ?? null), "autocomplete", array()), "html", null, true);
            echo "\"";
        }
        // line 13
        echo "            ";
        if (twig_in_filter($this->getAttribute(($context["field"] ?? null), "autofocus", array()), array(0 => "on", 1 => "true", 2 => 1))) {
            echo "autofocus=\"autofocus\"";
        }
        // line 14
        echo "            ";
        if (twig_in_filter($this->getAttribute(($context["field"] ?? null), "disabled", array()), array(0 => "on", 1 => "true", 2 => 1))) {
            echo "disabled=\"disabled\"";
        }
        // line 15
        echo "            ";
        if ($this->getAttribute(($context["field"] ?? null), "list", array(), "any", true, true)) {
            echo "list=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["field"] ?? null), "list", array()), "html", null, true);
            echo "\"";
        }
        // line 16
        echo "            ";
        if ($this->getAttribute(($context["field"] ?? null), "maxlength", array(), "any", true, true)) {
            echo "maxlength=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["field"] ?? null), "maxlength", array()), "html", null, true);
            echo "\"";
        }
        // line 17
        echo "            ";
        if ($this->getAttribute(($context["field"] ?? null), "minlength", array(), "any", true, true)) {
            echo "minlength=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["field"] ?? null), "minlength", array()), "html", null, true);
            echo "\"";
        }
        // line 18
        echo "            ";
        if ($this->getAttribute(($context["field"] ?? null), "pattern", array(), "any", true, true)) {
            echo "pattern=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["field"] ?? null), "pattern", array()), "html", null, true);
            echo "\"";
        }
        // line 19
        echo "            ";
        if ($this->getAttribute(($context["field"] ?? null), "placeholder", array(), "any", true, true)) {
            echo "placeholder=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["field"] ?? null), "placeholder", array()), "html", null, true);
            echo "\"";
        }
        // line 20
        echo "            ";
        if (twig_in_filter($this->getAttribute(($context["field"] ?? null), "readonly", array()), array(0 => "on", 1 => "true", 2 => 1))) {
            echo "readonly=\"readonly\"";
        }
        // line 21
        echo "            ";
        if (twig_in_filter($this->getAttribute(($context["field"] ?? null), "required", array()), array(0 => "on", 1 => "true", 2 => 1))) {
            echo "required=\"required\"";
        }
        // line 22
        echo "            ";
        if ($this->getAttribute(($context["field"] ?? null), "size", array(), "any", true, true)) {
            echo "size=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["field"] ?? null), "size", array()), "html", null, true);
            echo "\"";
        }
        // line 23
        echo "            />
";
    }

    public function getTemplateName()
    {
        return "forms/fields/input/url.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  119 => 23,  112 => 22,  107 => 21,  102 => 20,  95 => 19,  88 => 18,  81 => 17,  74 => 16,  67 => 15,  62 => 14,  57 => 13,  50 => 12,  45 => 10,  41 => 8,  37 => 7,  34 => 6,  31 => 4,  28 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "forms/fields/input/url.html.twig", "/home1/adboxadm/public_html/incentiva/administrator/components/com_gantry5/templates/forms/fields/input/url.html.twig");
    }
}
