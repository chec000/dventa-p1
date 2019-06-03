<?php

/* @particles/newsslider.html.twig */
class __TwigTemplate_85213e9dfe4b94dd651debca8127e755ade61c792bdc92842fc57f9244551630 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/newsslider.html.twig", 1);
        $this->blocks = array(
            'particle' => array($this, 'block_particle'),
            'javascript_footer' => array($this, 'block_javascript_footer'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@nucleus/partials/particle.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_particle($context, array $blocks = array())
    {
        // line 4
        echo "
    <div class=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "class", array()));
        echo "\">

        ";
        // line 7
        if ($this->getAttribute(($context["particle"] ?? null), "title", array())) {
            echo "<h2 class=\"g-title\">";
            echo $this->getAttribute(($context["particle"] ?? null), "title", array());
            echo "</h2>";
        }
        // line 8
        echo "
        <div class=\"g-newsslider\" id=\"";
        // line 9
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo "\" data-newsslider-id=\"";
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo "\" data-newsslider-autoplay=\"";
        if (($this->getAttribute(($context["particle"] ?? null), "autoplay", array()) == "1")) {
            echo "true";
        } else {
            echo "false";
        }
        echo "\" data-newsslider-delay=\"";
        echo twig_escape_filter($this->env, (($this->getAttribute(($context["particle"] ?? null), "delay", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["particle"] ?? null), "delay", array()), "5000")) : ("5000")), "html", null, true);
        echo "\">
            <div class=\"g-newsslider-preview news-preview\">

                ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["particle"] ?? null), "items", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 13
            echo "                    <div class=\"g-newsslider-content news-content\" style=\"";
            if ($this->getAttribute($context["item"], "image", array())) {
                echo "background-image: url('";
                echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->urlFunc($this->getAttribute($context["item"], "image", array())));
                echo "');";
            }
            echo "\">
                        <div class=\"g-newsslider-overlay\">
                            ";
            // line 15
            if ($this->getAttribute($context["item"], "title", array())) {
                // line 16
                echo "                                <div class=\"g-newsslider-preview-title\">";
                echo $this->getAttribute($context["item"], "title", array());
                echo "</div>
                            ";
            }
            // line 18
            echo "                            ";
            if ($this->getAttribute($context["item"], "desc", array())) {
                // line 19
                echo "                                <div class=\"g-newsslider-preview-desc\">";
                echo $this->getAttribute($context["item"], "desc", array());
                echo "</div>
                            ";
            }
            // line 21
            echo "                            ";
            if ($this->getAttribute($context["item"], "buttontext", array())) {
                // line 22
                echo "                                <span class=\"g-newsslider-button\">
                                    <a target=\"";
                // line 23
                echo twig_escape_filter($this->env, (($this->getAttribute($context["item"], "buttontarget", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "buttontarget", array()), "_self")) : ("_self")));
                echo "\" href=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "buttonlink", array()));
                echo "\" title=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "buttontext", array()));
                echo "\" class=\"button ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "buttonclass", array()));
                echo "\">
                                        ";
                // line 24
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "buttontext", array()));
                echo "
                                    </a>
                                </span>
                            ";
            }
            // line 28
            echo "                        </div>
                    </div>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        echo "
                <ul class=\"g-newsslider-pagination\">
                    ";
        // line 33
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["particle"] ?? null), "items", array()));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 34
            echo "                        <li>
                            ";
            // line 35
            echo $this->getAttribute($context["loop"], "index", array());
            echo "
                        </li>
                    ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 38
        echo "                </ul>
            </div>

            <div id=\"g-newsslider-scrollbar-";
        // line 41
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo "\" class=\"g-newsslider-scrollbar\">
                <ul class=\"g-newsslider-headlines news-headlines\">

                    ";
        // line 44
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["particle"] ?? null), "items", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 45
            echo "                        <li>
                            <div class=\"arrow-container\">
                                <i class=\"fa fa-chevron-right\"></i>
                            </div>

                            <span class=\"g-newsslider-headlines-title\">";
            // line 50
            echo $this->getAttribute($context["item"], "title", array());
            echo "</span>
                        </li>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 53
        echo "
                </ul>

                <div class=\"g-newsslider-navigation clearfix\">
                    <div class=\"prev\"><i class=\"fa fa-arrow-up\"></i></div>
                    <div class=\"next\"><i class=\"fa fa-arrow-down\"></i></div>
                </div>
            </div>
        </div>
    </div>

";
    }

    // line 66
    public function block_javascript_footer($context, array $blocks = array())
    {
        // line 67
        $this->getAttribute(($context["gantry"] ?? null), "load", array(0 => "jquery"), "method");
        // line 68
        echo "<script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->urlFunc("gantry-theme://js/newsslider.init.js"), "html", null, true);
        echo "\"></script>
";
    }

    public function getTemplateName()
    {
        return "@particles/newsslider.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  219 => 68,  217 => 67,  214 => 66,  199 => 53,  190 => 50,  183 => 45,  179 => 44,  173 => 41,  168 => 38,  151 => 35,  148 => 34,  131 => 33,  127 => 31,  119 => 28,  112 => 24,  102 => 23,  99 => 22,  96 => 21,  90 => 19,  87 => 18,  81 => 16,  79 => 15,  69 => 13,  65 => 12,  49 => 9,  46 => 8,  40 => 7,  35 => 5,  32 => 4,  29 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@particles/newsslider.html.twig", "/home1/adboxadm/public_html/incentiva/templates/rt_photon/particles/newsslider.html.twig");
    }
}
