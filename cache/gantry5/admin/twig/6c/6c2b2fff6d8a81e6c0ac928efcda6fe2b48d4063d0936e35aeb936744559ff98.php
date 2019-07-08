<?php

/* forms/fields/gantry/atoms.html.twig */
class __TwigTemplate_4db615365ef460bf92023870b4428b8b834724c3e64b60f11d95ed6c348e19b5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'label' => array($this, 'block_label'),
            'input' => array($this, 'block_input'),
        );
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return $this->loadTemplate((("forms/" . (((isset($context["layout"]) || array_key_exists("layout", $context))) ? (_twig_default_filter(($context["layout"] ?? null), "field")) : ("field"))) . ".html.twig"), "forms/fields/gantry/atoms.html.twig", 1);
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 3
        $context["outline"] = (($this->getAttribute(($context["field"] ?? null), "outline", array())) ? ($this->getAttribute(($context["field"] ?? null), "outline", array())) : ($this->env->getExtension('Gantry\Component\Twig\TwigExtension')->nestedFunc(($context["data"] ?? null), (($context["scope"] ?? null) . $this->getAttribute(($context["field"] ?? null), "outline_field", array())))));
        // line 4
        $context["atoms"] = (($this->getAttribute(($context["field"] ?? null), "atoms", array())) ? ($this->getAttribute(($context["field"] ?? null), "atoms", array())) : (((($context["outline"] ?? null)) ? ($this->getAttribute($this->getAttribute(($context["gantry"] ?? null), "outlines", array()), "getAtomInstances", array(0 => ($context["outline"] ?? null), 1 => $this->getAttribute(($context["field"] ?? null), "atom", array()), 2 => false), "method")) : (array()))));
        // line 1
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 6
    public function block_label($context, array $blocks = array())
    {
        // line 7
        echo "    ";
        $this->displayParentBlock("label", $context, $blocks);
        echo "
    <div><span class=\"particle-label-subtype badge\">";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute(($context["field"] ?? null), "atom", array()), "html", null, true);
        echo "</span></div>
";
    }

    // line 11
    public function block_input($context, array $blocks = array())
    {
        // line 12
        echo "    <div id=\"";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["field"] ?? null), "id", array()), "html", null, true);
        echo "\">
        ";
        // line 13
        if (($context["atoms"] ?? null)) {
            // line 14
            echo "            <div class=\"input-group\">
                ";
            // line 15
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["atoms"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["atom"]) {
                // line 16
                echo "                    <label for=\"";
                echo twig_escape_filter($this->env, (((($this->getAttribute(($context["field"] ?? null), "id", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["field"] ?? null), "id", array()), (($context["scope"] ?? null) . ($context["name"] ?? null)))) : ((($context["scope"] ?? null) . ($context["name"] ?? null)))) . "-") . $this->getAttribute($context["atom"], "id", array())), "html", null, true);
                echo "\">
                        <input
                                id=\"";
                // line 18
                echo twig_escape_filter($this->env, (((($this->getAttribute(($context["field"] ?? null), "id", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["field"] ?? null), "id", array()), (($context["scope"] ?? null) . ($context["name"] ?? null)))) : ((($context["scope"] ?? null) . ($context["name"] ?? null)))) . "-") . $this->getAttribute($context["atom"], "id", array())), "html", null, true);
                echo "\"
                                type=\"radio\"
                                name=\"";
                // line 20
                echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->fieldNameFilter((($context["scope"] ?? null) . ($context["name"] ?? null))), "html", null, true);
                echo "\"
                                value=\"";
                // line 21
                echo twig_escape_filter($this->env, $this->getAttribute($context["atom"], "id", array()), "html", null, true);
                echo "\"
                                required=\"required\"
                                ";
                // line 23
                if ((($context["value"] ?? null) == $this->getAttribute($context["atom"], "id", array()))) {
                    echo "checked=\"checked\"";
                }
                // line 24
                echo "                        />
                        <span>";
                // line 25
                echo twig_escape_filter($this->env, $this->getAttribute($context["atom"], "title", array()), "html", null, true);
                echo "</span>
                        <i class=\"fa fa-info-circle fa-fw\" aria-hidden=\"true\"></i>
                    </label>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['atom'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 29
            echo "            </div>
        ";
        } else {
            // line 31
            echo "            ";
            echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->transFilter("GANTRY5_PLATFORM_NO_INHERITANCE_SELECT_OUTLINE"), "html", null, true);
            echo "
        ";
        }
        // line 33
        echo "    </div>
";
    }

    public function getTemplateName()
    {
        return "forms/fields/gantry/atoms.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  111 => 33,  105 => 31,  101 => 29,  91 => 25,  88 => 24,  84 => 23,  79 => 21,  75 => 20,  70 => 18,  64 => 16,  60 => 15,  57 => 14,  55 => 13,  50 => 12,  47 => 11,  41 => 8,  36 => 7,  33 => 6,  29 => 1,  27 => 4,  25 => 3,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "forms/fields/gantry/atoms.html.twig", "C:\\xampp\\htdocs\\dventa\\administrator\\components\\com_gantry5\\templates\\forms\\fields\\gantry\\atoms.html.twig");
    }
}
