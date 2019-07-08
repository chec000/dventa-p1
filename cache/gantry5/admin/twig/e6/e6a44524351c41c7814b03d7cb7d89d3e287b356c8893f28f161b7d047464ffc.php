<?php

/* forms/fields/gantry/module.html.twig */
class __TwigTemplate_a527952b4df45ad9030f3c0f4631003a71430a8a3f5f6e321c7c9ccbf1ee95b2 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'input' => array($this, 'block_input'),
        );
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return $this->loadTemplate(((($context["default"] ?? null)) ? ("partials/field.html.twig") : ((("forms/" . (((isset($context["layout"]) || array_key_exists("layout", $context))) ? (_twig_default_filter(($context["layout"] ?? null), "field")) : ("field"))) . ".html.twig"))), "forms/fields/gantry/module.html.twig", 1);
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_input($context, array $blocks = array())
    {
        // line 4
        echo "    <input
            type=\"text\"
            name=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->fieldNameFilter((($context["scope"] ?? null) . ($context["name"] ?? null))));
        echo "\"
            value=\"";
        // line 7
        echo twig_escape_filter($this->env, twig_join_filter(($context["value"] ?? null), ", "));
        echo "\"
            ";
        // line 9
        echo "            ";
        $this->displayBlock("global_attributes", $context, $blocks);
        echo "
            ";
        // line 11
        echo "            ";
        if ($this->getAttribute(($context["field"] ?? null), "pattern", array(), "any", true, true)) {
            echo "pattern=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["field"] ?? null), "pattern", array()), "html", null, true);
            echo "\"";
        }
        // line 12
        echo "            ";
        if (twig_in_filter($this->getAttribute(($context["field"] ?? null), "disabled", array()), array(0 => "on", 1 => "true", 2 => 1))) {
            echo "disabled=\"disabled\"";
        }
        // line 13
        echo "            ";
        if (twig_in_filter($this->getAttribute(($context["field"] ?? null), "required", array()), array(0 => "on", 1 => "true", 2 => 1))) {
            echo "required=\"required\"";
        }
        // line 14
        echo "            />
    <span class=\"button\" data-g-instancepicker=\"";
        // line 15
        echo twig_escape_filter($this->env, twig_jsonencode_filter(array("type" => "module", "return" => true, "field" => $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->fieldNameFilter((($context["scope"] ?? null) . ($context["name"] ?? null))))), "html_attr");
        echo "\">";
        echo twig_escape_filter($this->env, (($this->getAttribute(($context["field"] ?? null), "picker_label", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["field"] ?? null), "picker_label", array()), "Pick a Module")) : ("Pick a Module")), "html", null, true);
        echo "</span>
";
    }

    public function getTemplateName()
    {
        return "forms/fields/gantry/module.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 15,  64 => 14,  59 => 13,  54 => 12,  47 => 11,  42 => 9,  38 => 7,  34 => 6,  30 => 4,  27 => 3,  18 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "forms/fields/gantry/module.html.twig", "C:\\xampp\\htdocs\\dventa\\administrator\\components\\com_gantry5\\templates\\forms\\fields\\gantry\\module.html.twig");
    }
}
